---
lang: en
permalink: docs/tracks
title: Tracks
---
Tracks collection of rules to apply. It may be defined as a complete test sequence 
or used as child track to create combo sequences. 

### Basic Track
Here is an exemple of a basic track.

```yaml
tracks:
    test-php-config:
        # Use Php Configuration Collector
        collector:      "php-config"
        # Give a short description for this track
        description:    "Verify PHP Configuration"
        enabled:        false
        # List of key <> rules
        rules:
            # This value should NOT be empty
            key-not-empty:          { ne: true }
```

### Combo Tracks
It is possible to reuse previously defined tracks in order to merge, 
complete or multiply tests to apply on a single track code.

Imagine you already defined two tracks, called "php-config" and "php-ext".
Those two track are here to check your default php configs & installed extensions. 

But you may want to check multiple installed PHP Versions.
```yaml
tracks:
    test-php-7.4:
        description:    "COMBO - Check Php 7.4"
        children:       [ "php-config", "php-ext" ]
        overrides:
            bin:    "/usr/bin/php7.4"
    test-php-7.3:
        description:    "COMBO - Check Php 7.3"
        children:       [ "php-config", "php-ext" ]
        overrides:
            bin:    "/usr/bin/php7.3"
```

This creates two tracks, including all rules of previously defined tracks, 
but with an override on the bin option so that tests are performed on a different PHP version. 
