# Ohanzee Components

Ohanzee is a set of PHP components that are dependency free, PSR compatible, and well documented. The design is guided by SOLID, DRY, and KISS (the SDK) philosophies.

Many were originally part of the Kohana PHP Framework.

# Testing

```
composer install --dev
phpunit
```

The default database connection details are:

- hostname: localhost
- database: ohanzee
- username: ohanzee
- password: (empty)

These values can be modified by copying `phpunit.xml.dist` to `phpunit.xml` in the root of the project and modifying the env vars:

```xml
<env name="DB_HOSTNAME" value="server"/>
<env name="DB_DATABASE" value="testing"/>
<env name="DB_USERNAME" value="jane"/>
<env name="DB_PASSWORD" value="likesblue"/>
```

