---
lang: en
permalink: docs/collectors
title: Collectors
---

Data collectors are here to collect data on local system.

Data may be provided by local php scripts, database requests, 
results of shell commands, result is always a string that will be analysed by a rule. 

For each data to collect, collector receive an input key. 
This key may be the name of a variable/extension/package to check, or a predefined point to check.

### Sample Configuration

When you define a track, you must a collector code, and may provide additional options.
```yaml
tracks:
    test-php-config:
        # Collector code is Required
        collector:      "php-config"        
        # Optional, provide options for your collector 
        options:                      
            bin:        "/usr/bin/php7.3"
```

### Available Collectors 
To see complete list of available collectors, uses this command.
```bash
$ php bin/console paddock:collectors
```