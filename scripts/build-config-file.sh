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

echo "\033[32m PADDOCK DEPLOY --> Build Config File \033[0m"

################################################################
# Ensure Dir Exists
if [ ! -d "build" ]; then mkdir "build"; fi

################################################################
# Safety Checks
if [ -z "${PADDOCK_CONFIG}" ];      then echo "Paddock: No Config file defined, Please set PADDOCK_CONFIG on environment."; exit; fi
if [ ! -f "${PADDOCK_CONFIG}" ];      then echo "Paddock: Config file not found: ${PADDOCK_CONFIG}"; exit; fi

################################################################
# Setup Config Directories
export PADDOCK_DIR=$(dirname $PADDOCK_CONFIG);
export PADDOCK_CONFIG=$(basename $PADDOCK_CONFIG);

################################################################
# Show Config Directories
echo " => Paddock: Config file is: ${PADDOCK_CONFIG}";
echo " => Paddock: Config files must be relative to: ${PADDOCK_DIR}";

################################################################
# Build Config File from Console
php bin/paddock paddock:export build/paddock.yml ${PADDOCK_CONFIG}
