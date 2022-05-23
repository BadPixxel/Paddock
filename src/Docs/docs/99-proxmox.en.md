---
lang: en
permalink: docs/proxmox-nrpe
title: Proxmox NRPE Plugin
---

Paddock includes spécial NRPE plugins to improve Proxmox Bare Metal server minitoring.

### Apt Updates
Check packages for Apt Updates. Key all is used to get 

```yaml
tracks:
    test-system-updates:
        collector:      "apt-updates"
        description:    "TEST - System Packages Update Status"
        rules:
              all:                { lt: "10" }
              security:           { lt: "5" }
```

### Apt Version
Check version of any System Package.

```yaml
tracks:
    test-system-packages:
        collector:      "apt-version"
        overrides:
            rule: version
        rules:
            curl:               { ne: true, gt: "7.50" }
            apache2:            { ne: true, gt: { error: "2.4.0" } }
```

### Active Services
Check any system service is active.

```yaml
tracks:
    test-system-services:
        collector:      "service"
        rules:
            apache2:            { ne: true }
```
