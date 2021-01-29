# EaseAmpMysqlRedis
> A very simple and safe PHP library that enables easy redis cache warmup from MySQL/MariaDB Database. This uses EaseAmpMysql and EaseAmpRedis packages, that wraps up the AmPHP related MySQL and Redis Packages to interact with MySQL/MariaDB database and also with Redis in-memory cache in an asynchronous & non-blocking way.

### Why EaseAmpMysqlRedis?
While Prepared Statements on Mysql/MariaDB can be done EaseAmpMysql package and interaction with Redis Cache can be done using EaseAmpRedis package, EaseAmpMysqlRedis class will be useful to do SQL Queries on MySQL/MariaDB in sync with Redis Cache in a simple and easy way.

### Advantages
- Easy wrapper methods to deal with SQL Queries and Redis Cache Operations.

### Getting started
With Composer, run

```sh
composer require invincible-tech-systems/easeamp-mysql-redis:^1.0.2
```

Note that the `vendor` folder and the `vendor/autoload.php` script are generated by Composer; they are not part of PDOLight.

To include the library,

```php
<?php
require 'vendor/autoload.php';

use \InvincibleTechSystems\EaseAmpMysql\EaseAmpMysql;
use \InvincibleTechSystems\EaseAmpRedis\EaseAmpRedis;
use \InvincibleTechSystems\EaseAmpMysqlRedis\EaseAmpMysqlRedis;
```

In order to connect to the database, you need to initialize the `EaseAmpMysql` class, by passing your database credentials as parameters, in the following order (server hostname, username, password, database name):


```php
$dbHost = "localhost";
$dbUsername = "database_username";
$dbPassword = "database_password_value";
$dbName = "database_name";

$dbConn = new EaseAmpMysql($dbHost, $dbUsername, $dbPassword, $dbName);
```

```php
$redisHost = 'tcp://localhost:6379';
$redisKeyNamespacePrefix = "MyFirstApp";
$redisKeyExpiryTimeInSeconds = 240;

$redisConn = new EaseAmpRedis($redisHost);
```


## License
This software is distributed under the [MIT](https://opensource.org/licenses/MIT) license. Please read [LICENSE](https://github.com/easeappphp/PDOLight/blob/main/LICENSE) for information on the software availability and distribution.
