---
lang: en
permalink: docs/mysql-collectors
title: MySQL Collectors
---

Paddock includes multiple data collector for monitoring MySQl Servers.

### MySQL Variables
Verify values of any MySQl configuration variable.

```yaml
tracks:
    test-mysql-config:
        collector:      "mysql-variable"
        description:    "Default MySQL Configuration"
        rules:
            '@@GLOBAL.table_definition_cache':              { gte: "1000" }
```

### Common Options
For each MySQl Collector, you may provide the 'url' option to . 
Without this override, collector will collect values of default database you have declared on .env file.
With this override, you can collect values of any database.

```yaml
tracks:
    test-mysql-config:
        collector:      "mysql-variable"
        description:    "Custom MySQL Configuration"
        options:
            url:        "mysql://user:password@server-url:3306/database-name"
        rules:
            '@@GLOBAL.table_definition_cache':              { gte: "1000" }
```

If you are using Paddock inside a symfony project, 
it's also possible to use a doctrine connexion via 'dbal' option.