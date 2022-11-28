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

echo "\033[32m PADDOCK SSHPASS DEPLOY --> Start     \033[0m"

################################################################
# Safety Checks
################################################################
if [ -z "${HOST}" ];      then echo "SSH Pass: Host is empty"; exit; fi
if [ -z "${PORT}" ];      then echo "SSH Pass: Port is empty"; exit; fi
if [ -z "${USERNAME}" ];  then echo "SSH Pass: Username is empty"; exit; fi
if [ -z "${PASSWORD}" ];  then echo "SSH Pass: Password is empty"; exit; fi

################################################################
# SSH DEPLOY
################################################################
sshpass -p "${PASSWORD}" ssh -o StrictHostKeyChecking=no ${USERNAME}@${HOST} -p ${PORT} "`sh scripts/build-deploy-script.sh`"

echo "\n";
echo "\033[32m PADDOCK SSHPASS DEPLOY --> End     \033[0m";
