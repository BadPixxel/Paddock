---
lang: en
permalink: docs/mongodb-collectors
title: MongoDb Collectors
---

Paddock includes multiple data collector for monitoring Mongodb Servers.

### MongoDb Version
Check version of MongoDb Server.

```yaml
tracks:
    test-mongo-version:
        collector:      "mongo-version"
        rules:
            version:
                rule: version
                gt: { error: "3.6.0", warning: "4.0" }
                lt: { error: "6.0.0" }
```

### MongoDb Configuration
Check value of any MongoDb Server Configuration key.

```yaml
tracks:
    test-mongo-config:
        collector:      "mongo-variable"
        rules:
            documentUnitSizeBytes:                    { gte: "128", lte: 200 }
            featureCompatibilityVersion:              { gte: "5.0" }
```

### MongoDb Statistics
Check value of any MongoDb Server Statistics key.

```yaml
tracks:
    test-mongo-config:
        collector:      "mongo-stats"
        rules:
            # Ensure results scale factor is 1024
            scaleFactor:              { eq: "1024" }
            # Total disk space is above 10G
            fsTotalSize:              { gte: "10G" }
            # Remaining disk free space is above 1G
            fsFreeSize:               { gte: "1G" }
```

### Common Options
For each MongoDb Collector, you may provide the 'url' option to override server & database url. 
Without this override, collector will collect values of default database you have declared on .env file.
With this override, you can collect values of any database.
