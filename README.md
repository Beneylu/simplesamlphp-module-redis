Redis module for simpleSAMLphp
==============================


This module allow to use redis / redis sentinel as a data store for simpleSAMLphp


Setup
-----

Next you must install this module either by obtaining the tarball or by
installing it via composer. The latter is recommended

    composer.phar require beneylu-school/simplesamlphp-module-redis *

This will automatically install `predis/predis` as a dependency for the
module. If you downloaded the module yourself, remember to add predis/predis as
a dependency in your `composer.json`.

See https://github.com/simplesamlphp/composer-module-installer for more
information on how to insatll simpleSAMLphp modules via composer.

and copy the config file

    cp /var/simplesamlphp/modules/redis/config-templates/module_redis.php /var/simplesamlphp/config

Edit the config file so it fits your setup.

To use redis as a simpleSAMLphp datastore add the following setting in `config.php`

    'store.type' => 'redis:Redis'
