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

################################################################
# Force Failure if ONE line Fails
set -e

######################################
# Splash Screen
echo "  /==============================/";
echo " / PADDOCK PROXMOX NRPE DEPLOY  / ";
echo "/==============================/  ";

######################################
# Binaries
DIR_PLUGINS="/usr/lib/nagios/plugins"
DIR_CONFIG="/etc/nagios/nrpe.d"
URL_PLUGINS="https://raw.githubusercontent.com/BadPixxel/Paddock/master/src/Apps/Nrpe/Resources/plugins"
################################################################
# Read User Inputs
echo "VM IDs to monitor? i.e 100,200,300"
read  VMIDs
VMIDs=${VMIDs:-100}
echo "Backup name? Default 'backup-server'"
read  BACKUP_NAME
BACKUP_NAME=${BACKUP_NAME:-backup-server}
echo "[OK] Let's monitor VMs $VMIDs for '$BACKUP_NAME' Backups !"
################################################################
# Import NRPE Plugins
if [ ! -d "$DIR_PLUGINS" ]; then
    echo "[KO] Directory $DIR_PLUGINS does not exits"
    exit 0
fi
curl -s -o "$DIR_PLUGINS/check_prx_backups.sh" "$URL_PLUGINS/check_prx_backups.sh"
chmod 775 "$DIR_PLUGINS/check_prx_backups.sh"
curl -s -o "$DIR_PLUGINS/check_prx_status.sh" "$URL_PLUGINS/check_prx_status.sh"
chmod 775 "$DIR_PLUGINS/check_prx_status.sh"
echo "[OK] Plugins Downloaded to $DIR_PLUGINS"
################################################################
# Generate NRPE Config File
if [ ! -d "$DIR_CONFIG" ]; then
    echo "[KO] Directory $DIR_CONFIG does not exits"
    exit 0
fi
CONFIG_FILE="$DIR_CONFIG/paddock_prx.cfg"
echo "################################################################" >  $CONFIG_FILE
echo "#                PADDOCK NRPE CONFIG FOR PROXMOX               #" >> $CONFIG_FILE
echo "################################################################" >> $CONFIG_FILE
echo "# This file was auto-generated, so don't touch please !        #" >> $CONFIG_FILE
echo "################################################################" >> $CONFIG_FILE
echo "command[check_prx_backups]=/usr/lib/nagios/plugins/check_prx_backups.sh $VMIDs 3 $BACKUP_NAME" >> $CONFIG_FILE
echo "command[check_prx_status]=/usr/lib/nagios/plugins/check_prx_status.sh $VMIDs" >> $CONFIG_FILE
echo "[OK] NRPE Config Generated to $CONFIG_FILE"
################################################################
# Restart NRPE Service
if [ ! -f "/etc/init.d/nagios-nrpe-server" ]; then
    echo "[KO] NRPE Service was not found"
    exit 0
fi
/etc/init.d/nagios-nrpe-server restart
echo "[OK] NRPE Service Restarted"