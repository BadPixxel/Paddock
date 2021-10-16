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

echo "\033[32m PADDOCK DEPLOY --> Build .env File \033[0m"

################################################################
# Ensure Dir Exists
if [ ! -d "build" ]; then mkdir "build"; fi

################################################################
# Build Env File
cp "scripts/.env.dist" "build/.env"
# Setup Backup Location
if [ -z "${PADDOCK_BACKUP}" ]; then PADDOCK_BACKUP=""; echo " => No Backup Location Defined"; fi
php -r "file_put_contents('./build/.env', str_replace('%PADDOCK_BACKUP%', '${PADDOCK_BACKUP}', file_get_contents('./build/.env')));"
# Setup Default Mysql Url
if [ -z "${DATABASE_URL}" ]; then DATABASE_URL="mysql://root:@localhost:3306"; echo " => No MySql Database Url Defined"; fi
php -r "file_put_contents('./build/.env', str_replace('%DATABASE_URL%', '${DATABASE_URL}', file_get_contents('./build/.env')));"
# Setup Default Mongodb Url
if [ -z "${MONGODB_URL}" ]; then MONGODB_URL="mongodb://mongodb:27017"; echo " => No Mongodb Database Url Defined";  fi
php -r "file_put_contents('./build/.env', str_replace('%MONGODB_URL%', '${MONGODB_URL}', file_get_contents('./build/.env')));"
