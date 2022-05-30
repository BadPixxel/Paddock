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

readonly SCRIPTNAME="$(basename "${BASH_SOURCE[0]}")"

######################################
# HELP
function usage() {
        echo "./check_prx_version.sh MinVersion"
        echo
        echo "MinVersion:   Minimal Server Version"
        echo
        echo "Options:"
        echo "  -h, --help    Show this help message and exit."
        echo
        echo "Examples:"
        echo "$SCRIPTNAME 2.1.0"
        exit 1
}
######################################
# VERSIONS COMPARE FUNCTIONS
function version_gt() { test "$(echo "$@" | tr " " "\n" | sort -V | head -n 1)" != "$1"; }
function version_le() { test "$(echo "$@" | tr " " "\n" | sort -V | head -n 1)" == "$1"; }
function version_lt() { test "$(echo "$@" | tr " " "\n" | sort -rV | head -n 1)" != "$1"; }
function version_ge() { test "$(echo "$@" | tr " " "\n" | sort -rV | head -n 1)" == "$1"; }
######################################
# Safety Checks
if [[ -z $1 || "$1" = "-h" || "$1" = "--help" ]]; then
    usage
fi
######################################
# Read PVE Version
VERSION=$(pveversion | grep "manager" | cut -d'/' -f 2 | cut -d'-' -f 1);
######################################
# Compare Version
if version_ge $VERSION $1; then
    echo "OK - PVE Version $VERSION is above $1"
    exit 0
fi

echo "KO - PVE Version $VERSION is lower to $1"
exit 1
