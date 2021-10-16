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

FROM registry.gitlab.com/badpixxel-projects/php-sdk:php-7.4

################################################################################
# Clone Badpixxel Paddpock Project
RUN git clone https://github.com/BadPixxel/Paddock.git --depth=1 /var/www/html
ADD .env /var/www/html
ENV PADDOCK_SCRIPT_DIR: '/var/www/html/scripts'

################################################################################
# Install Composer
ENV COMPOSER_MEMORY_LIMIT: -1
ENV COMPOSER_HOME: '/home/docker/.composer'
RUN cd /var/www/html && composer update --prefer-dist --no-interaction --no-progress

################################################################
# Install Varions Tools
################################################################

RUN apt-get update \
    && apt-get install --no-install-recommends -y git curl ssh sshpass \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*




