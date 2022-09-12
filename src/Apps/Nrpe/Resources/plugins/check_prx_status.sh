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

######################################
# HELP
function usage() {
        echo "./check_proxmox_status.sh <VMIDs>"
        echo
        echo "VMIDs:          VMIDs of the vm's you want to check. I.e 100,200,300"
        echo
        echo "The user nagios executes the pvesm binary via sudo. For this to work you have to modify your /etc/sudoers. E.g:"
        echo "  'nagios ALL=NOPASSWD: /usr/sbin/pvesm list *, /usr/bin/pvectl list *, /usr/bin/lxc-ls, /usr/sbin/qm list, /usr/sbin/qm status *, /usr/sbin/qm start *'"
        echo
        exit 1
}

######################################
# VM CHECK
function check_vm() {
        ######################################
        # Check if VM Exists
        if ! $QM list |grep $@ > /dev/null 2>&1 ; then
                echo "> [$@] Unknown: VM $@ does not exist"
                exit 3
        fi
        #####################################
        # Check if VM is Running
        if $QM status $@ | grep "running" > /dev/null 2>&1 ; then
                set_ok_vm $@
        else
                echo "> [$@] Error - VM $@ is not Running"
                start_vm $@
                exit 3
        fi
}

######################################
# VM CHECK
function start_vm() {

        ######################################
        # Check Number of Restart Tests
        if [[ -f /tmp/prx_status.txt ]]; then
                source /tmp/prx_status.txt
        fi
        if [[ -z NB_RESTART ]]; then
                declare -A NB_RESTART
        fi
        if [[ ! -v NB_RESTART[$@] ]]; then
                NB_RESTART[$@]=0
        fi
        ######################################
        # Try to Restart VM
        if [[ ${NB_RESTART[$@]} < 4 ]]; then
                echo "> [$@] Try to restart VM..."
                $QM start $@
        else
                echo "> [$@] Too much restart of VM... Skipped"
        fi
        ######################################
        # Increment Number of Restart Tests
        NB_RESTART[$@]=$((NB_RESTART[$@]+1))
        declare -p NB_RESTART > /tmp/prx_status.txt
}

######################################
# VM IS OK
function set_ok_vm() {
        if [[ -f /tmp/prx_status.txt ]]; then
                source /tmp/prx_status.txt
        fi
        if [[ -z NB_RESTART ]]; then
                declare -A NB_RESTART
        fi
        NB_RESTART[$@]=0
        declare -p NB_RESTART > /tmp/prx_status.txt
}

if [[ -z $1 ]]; then
        usage
fi


######################################
# VMIDs of the VMs you want to check
IDS=$(echo $1 | tr "," "\n")
######################################
# Walk on VM IDs
######################################
for ID in $IDS
do
       check_vm "$ID"
done

echo "Ok - [$1] - All VMs are Running !!"
exit 0