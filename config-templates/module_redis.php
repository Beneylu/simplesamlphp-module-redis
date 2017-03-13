<?php

$config = array (
    // Redis server parameters used to initialize Predis\Client
    'redis.parameters' => null,
    // Redis server options used to initialize Predis\Client
    'redis.options' => null,
    // Redis Client class default to Predis\Client
    'redis.class' => '\BNS\CommonBundle\Redis\PredisClient',
    // Key prefix
    'prefix' => 'saml:',
    // Lifitime for all non expiring keys
    'lifetime' => 288000
);
