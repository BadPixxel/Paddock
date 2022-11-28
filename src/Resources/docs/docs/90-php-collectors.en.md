---
lang: en
permalink: docs/php-collectors
title: PHP Collectors
---

Paddock includes multiple data collector for monitoring Php Web Servers.

### Php Configuration
Verify values of any Php configuration variable.

```yaml
tracks:
    test-php-config:
        collector:      "php-config"
        rules:
          upload_max_filesize:              { gt: 1M, eq: 2048k, lt: 1G }
```

### Php Constants
Verify values of any Php constant.

```yaml
tracks:
    test-php-constant:
        collector:      "php-constant"
        rules:
            PHP_VERSION:    { rule: version, gt: { error: "7.2.0" } }
```

### Php Environment Constants
Verify values of any Php environment constant.

```yaml
tracks:
    test-php-env:
        collector:      "php-env"
        rules:
            PHP_VERSION:    { rule: version, gt: { error: "7.2.0" } }
```

### Php Extensions
Verify any Php extension is installed, and check installed version.

```yaml
tracks:
    test-php-ext:
        collector:      "php-ext"
        rules:
            # Extension php-curl must be active 
            curl:         { ne: true }
            # Extension php-mongodb must be active and version above 1.6.0 
            mongodb:      { ne: true, gt: { warning: "1.6" },  }
```

### Common Options
For each Php Collector, you may provide the 'bin' option. 
Without this override, collector will collect values of default Php Version.
With this override, you can collect values of any installed php version from its binary.

```yaml
tracks:
    test-php-config:  
        # Collect values from given binary 
        options:                      
            bin:        "/usr/bin/php7.3"
```
