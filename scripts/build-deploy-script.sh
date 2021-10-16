################################################################################
#
# * This file is part of SplashSync Project.
# *
# * Copyright (C) Splash Sync <www.splashsync.com>
# *
# * This program is distributed in the hope that it will be useful,
# * but WITHOUT ANY WARRANTY; without even the implied warranty of
# * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
# *
# * For the full copyright and license information, please view the LICENSE
# * file that was distributed with this source code.
# *
# * @author Bernard Paquier <contact@splashsync.com>
#
################################################################################

echo "\033[32m PADDOCK DEPLOY --> Build SSH Script \033[0m"

echo "echo '`cat scripts/deploy-paddock.sh`' > /tmp/deploy-paddock.sh;"
echo "echo '`cat build/.env`' > /tmp/.env;"
echo "echo '`cat build/paddock.yml`' > /tmp/paddock.yml;"
echo "bash /tmp/deploy-paddock.sh; exit;"
