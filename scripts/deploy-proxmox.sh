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

################################################################
# Read User Inputs
echo "VM IDs to monitor? i.e 100,200,300"
read  VMIDs
VMIDs=${VMIDs:-100}
echo "Backup name? Default 'backup-server'"
read  BACKUP_NAME
BACKUP_NAME=${BACKUP_NAME:-backup-server}
echo "Ok, let's monitor VMs $VMIDs for '$BACKUP_NAME' Backups"
################################################################
# Import

if [ ! -d "/etc" ]; then
    echo "[KO] Directory /etc does not exits"
    exit 0
fi


if [ ! -d "$DIR_PLUGINS" ]; then
    echo "[KO] Directory $DIR_PLUGINS does not exits"
    exit 0
fi


