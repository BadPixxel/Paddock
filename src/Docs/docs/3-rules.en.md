---
lang: en
permalink: docs/rules
title: Rules
---
Track's rules are there to analyse values provided by Collectors.

A rule may contain multiple checks to apply, with different log levels.

Default rule is "value" rule. A combo rule that allow analyzing most common collector results.

### Basic Checks
Here are exemples of basic checks that may be applied to a collector key.

```yaml
tracks:
    test-php-config:
        # Use Php Configuration Collector
        collector:      "php-config"  
        # List of key <> rules
        rules:
            # This value should be empty
            key-empty:              { empty: true }
            # This value should NOT be empty
            key-not-empty:          { ne: true }
            # This value should be equal to false
            key-equal:              { eq: false }
            # This value should be same as false
            key-same:               { eq: false }
            # This value should be greater to 10
            key-greater:            { gt: 10 }
            # This value should be greater or equal to 10
            key-greater-equal:      { gte: 10 }
            # This value should be below 10
            key-lower:              { lt: 10 }
            # This value should be below or equal to 10
            key-lower-equal:        { lte: 10 }
            # This value should be below or equal to 10
            key-scalar:             { scalar: true }
```

### Version Checks
To check a software version, just change rule type on your definition for 'version'. 

```yaml
tracks:
    test-php-config:
        # Use Php Constants Collector
        collector:      "php-constant"  
        # List of key <> rules
        rules:
          # Check PHP Version is greater or equal to 7.2
          PHP_VERSION:            { rule: version, gte: "7.2.0" }
```

### Log Levels
It's possible to mix all different values with different logging levels.

```yaml
    rules:
        opcache.max_accelerated_files:  { gte: { error: 1000, warning: 10000, info: 35000} }
```

In this case, if value is below 1 000, an error will be triggered. 
If value is just below 10 000, a warning will be reported.
But if value is just below 35 000, no error or warning will be reported, just an info message when Paddock runs on console.

### Advanced rules configurations
It's possible to mix all this to create fully customized rules.

I.e. here collector & rule type are overridden from rule definition.
```yaml
    rules:
      # PHP Version
      PHP_VERSION: { collector: "php-constant", rule: version, gt: { error: "7.2.0", warning: "7.4.0" } }
```

### Available Rules
To see complete list afo available rules, uses this command.

```bash
$ php bin/console paddock:rules
```
