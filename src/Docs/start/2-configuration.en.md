---
lang: en
permalink: start/configure
title: Configuration
---

Paddock configuration is based on two file.

### .env - Environment definition file

This file must be placed on root directory and define global configuration for Paddock.
Please note each variable defined here may also be defined in environment. 

```ini
###> badpixxel/paddock ###
PADDOCK_CONFIG="paddock.yml"
PADDOCK_BACKUP="file:///tmp/backups/location1; zip:/tmp/backups/location2"
###< badpixxel/paddock ###

###> doctrine/doctrine-bundle ###
DATABASE_URL="mysql://root:admin@mysql:3306/paddock"
###< doctrine/doctrine-bundle ###

###> doctrine/doctrine-odm-bundle ###
MONGODB_URL="mongodb://mongodb:27017/paddock"
###< doctrine/doctrine-odm-bundle ###
```

**PADDOCK_CONFIG** : Relative or Absolute location of Paddock configuration file. 
Default is paddock.yml 

**PADDOCK_BACKUP** : List of available backup locations, comma separated.

**DATABASE_URL** : Url of default MySQl database.

**MONGODB_URL** : Url of default MongoDb database.

### paddock.yml - Paddock Configuration file

This file may be placed anywhere in your system. It defined all configurations for Paddock system.

* Tracks definitions: List of all tests suites to perform.
* Backups definition: List oif all available backup operations.

See below a very simple exemple of definition. 

```yaml
tracks:

    test-php-config:
        collector:      "php-config"
        description:    "TEST - PHP Configuration"
        rules:
              # PHP Core Config
              session.auto_start:               { eq: false }
              upload_max_filesize:              { gt: 1M, eq: 2048k, lt: 1G }

    test-php-extensions:
          collector:      "php-ext"
          description:    "TEST - PHP Extensions"
          rules:
                curl:         { ne: true }
                gd:           { ne: true }
                json:         { ne: true }
                pdo_mysql:    { ne: true }
                xml:          { ne: true }

backups:

    local-to-local:
        description:    "Local to Local Backup"
        source:         "file:///var/www/source"
```

This file defines two 'tracks' and one 'backup'.

**test-php-config** Will check that PHP flag 'session.auto_start' is set to false. And 'upload_max_filesize' is greater that 1 Megabyte, equal to 2048 kilobytes, lower than 1 Gigabyte.

**test-php-extensions** Will check that PHP extensions 'curl', 'gd' are installed. 

**local-to-local** Will perform a basic backup of all files in '/var/www/source' to all configured locations. 