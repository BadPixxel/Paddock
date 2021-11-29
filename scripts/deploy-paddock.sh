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

echo "\033[31m                             /==============================/    \033[0m";
echo "\033[31m                            /   PADDOCK DEPLOY SCRIPT      /     \033[0m";
echo "\033[31m                           /==============================/      \033[0m";

INSTALL_PATH="/usr/local/lib/paddock";
GIT_URL="https://github.com/BadPixxel/Paddock.git";

################################################################
# Clone or Pull from Github
################################################################
echo "\033[32m Update from GIT Repository             \033[0m";
if [ -f "${INSTALL_PATH}/composer.json" ]; then
  echo "Paddock is Already Installed"
  cd ${INSTALL_PATH}
  git stash && git checkout -f && git pull
else
  echo "Clone & Install Paddock from Git"
  git clone ${GIT_URL} ${INSTALL_PATH} --depth=1
fi
cd ${INSTALL_PATH}

################################################################
# Run Composer Install
################################################################
echo "\033[32m Composer Install                       \033[0m";
composer update

################################################################
# Setup Paddock
################################################################
echo "\033[32m Paddock Setup                         \033[0m";
cp /tmp/.env ${INSTALL_PATH}/.env;
cp /tmp/paddock.yml ${INSTALL_PATH}/paddock.yml;
php bin/console paddock:nrpe:deploy
/etc/init.d/nagios-nrpe-server restart

################################################################
# Show Paddock Help
################################################################
echo "\033[32m Paddock Available Commands            \033[0m";
php bin/console | grep paddock
echo "\033[32m Paddock Available Tracks              \033[0m";
php bin/console paddock:tracks
echo "\033[32m Paddock Available Backups             \033[0m";
php bin/console paddock:backup:status

echo "\033[32m Paddock Status             \033[0m";
php bin/console paddock:run -f=nrpe -n --no-debug
