#!/bin/bash
################################################################################
#
# Copyright (C) 2020 BadPixxel <www.badpixxel.com>
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
#
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.
#
################################################################################

######################################
# Binaries
PVESM="sudo /usr/sbin/pvesm"
PVECTL="sudo /usr/bin/pvectl"
LXCLS="sudo /usr/bin/lxc-ls"
QM="sudo /usr/sbin/qm"
# Temp file for pvesm output
LIST=/tmp/pvesmlist

function usage() {
        echo "./check_proxmox_backup.sh <VMIDs> <MAX_OLD_DAYS> <STORAGE> "
        echo
        echo "VMIDs:            VMIDs of the vm's you want to check. I.e 100,200,300"
        echo "MAX_OLD_DAYS:     The script will trigger a critical alert if the backup is older then the days specified in this var."
        echo "STORAGE:          Name of your proxmox backup storage. Default backup-server"
        echo
        echo "The user nagios executes the pvesm binary via sudo. For this to work you have to modify your /etc/sudoers. E.g:"
        echo "  'nagios ALL=NOPASSWD: /usr/sbin/pvesm list *, /usr/bin/pvectl list *, /usr/bin/lxc-ls, /usr/sbin/qm list *'"
        echo
        exit 1
}

######################################
# CHECK VM QEMU BACKUPS
function check_qemu_backups() {
          echo "$storageList" | grep "vzdump-qemu-$@" > $LIST
          COUNT=$(wc -l < $LIST)
          if [ $COUNT -gt 0 ]; then
                BACKUP_COUNT=$COUNT
                BACKUP_TYPE="QEMU"
                LINE=$(cat $LIST | tail -1)
                BACKUP_DATE_A=$(echo $LINE | cut -d' ' -f 1 | cut -d'-' -f 5| sed "s/_/-/g")
                BACKUP_DATE_B=$(echo $LINE | cut -d' ' -f 1 | cut -d'-' -f 6| cut -d'.' -f 1| sed "s/_/:/g")
                BACKUP_DATE="$BACKUP_DATE_A $BACKUP_DATE_B"
                BACKUP_SIZE=$(echo $LINE | cut -d' ' -f 4)
          fi
}

######################################
# CHECK VM PRX BACKUP SERVER BACKUPS
function check_server_backups() {
        echo "$storageList" | grep "/vm/$@" > $LIST
        COUNT=$(wc -l < $LIST)
        if [ $COUNT -gt 0 ]; then
                LINE=$(cat $LIST | tail -1)
                BACKUP_TYPE="Prx Server"
                BACKUP_COUNT=$COUNT
                BACKUP_DATE=$(echo $LINE | cut -d' ' -f 1 | cut -d'/' -f 4)
                BACKUP_SIZE=$(echo $LINE | cut -d' ' -f 4)
        fi
}

######################################
# CHECK VM BACKUPS
function check_vm_backups() {
        ######################################
        # Check if VM Exists
        if ! $QM list |grep $@ > /dev/null 2>&1 ; then
                echo "> [$@] Unknown: VM $@ does not exist"
                exit 3
        fi
        #####################################
        # Check if Backup Storage Exists
        storageList=$($PVESM list $BACKUP_STORAGE 2>/dev/null);
        if [ $? -ne 0 ]; then
                echo "> [$@] Critical - Storage $BACKUP_STORAGE does not exist"
                exit 2
        fi
        #####################################
        # Count Number of Backup For VM
        BACKUP_COUNT=0
        check_qemu_backups $@
        check_server_backups $@
        if [ $BACKUP_COUNT -eq 0 ]; then
            echo "> [$@] Critical - No backups of vm $@"
            exit 2
        fi
        #####################################
        # Check Last Backup Age
        BACKUP_DATE_STAMP=$(date -d "$BACKUP_DATE" '+%s')
        let "BACKUP_SIZE_MB=$BACKUP_SIZE / 1024 / 1024"
        if [[ $MAX_OLD_DATE -ge $BACKUP_DATE_STAMP ]]; then
            let "BACKUP_SIZE_MB=$BACKUP_SIZE / 1024 / 1024"
            echo "> [$@][$BACKUP_TYPE] Critical - $BACKUP_COUNT backups. Last from $BACKUP_DATE ($BACKUP_SIZE_MB MB)."
            exit 2
        else
            echo "> [$@][$BACKUP_TYPE] OK - $BACKUP_COUNT backups. Last from $BACKUP_DATE ($BACKUP_SIZE_MB MB)."
        fi
}

######################################
# Check Required Inputs Parameters
if [[ -z $1 || -z $2 ]]; then
        usage
fi
######################################
# VMIDs of the VMs you want to check
IDS=$(echo $1 | tr "," "\n")
# The script triggers an critical alert if the last backup is older than $MAX_OLD_DAYS days
MAX_OLD_DAYS=$2
MAX_OLD_DATE=$(date -d "$MAX_OLD_DAYS day ago" '+%s')
# Name of your proxmox backup storage
if [[ -z $3 ]]; then
        BACKUP_STORAGE="backup-server"
else
        BACKUP_STORAGE=$3
fi

######################################
# Walk on VM IDs
######################################
for ID in $IDS
do
       check_vm_backups "$ID"
done

echo "Ok - [$1] - All Backups are Up to Date !!"
exit 0