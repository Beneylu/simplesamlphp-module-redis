<?php

/**
 * @author Jérémie Augustin <jeremie.augustin@pixel-cookers.com>
 */
class sspmod_redis_Store_Redis extends SimpleSAML_Store
{
    /**
     * @var \Predis\Client
     */
    private $redis;
    /**
     * @var string redis prefix in the data store
     */
    private $prefix;

    /**
     * @var int defualt lifetime of a key
     */
    private $lifeTime;

    public function __construct()
    {
        $redisConfig = SimpleSAML_Configuration::getConfig('module_redis.php');

        $parameters = $redisConfig->getValue('redis.parameters', null);
        $options = $redisConfig->getValue('redis.options', null);
        $class = $redisConfig->getString('redis.class', 'Predis\Client');

        /** @var \Predis\Client redis */
        $this->redis = new $class($parameters, $options);

        $this->prefix = $redisConfig->getString('prefix', 'simpleSAMLphp');
        $this->lifeTime = $redisConfig->getInteger('lifetime', 28800); // 8 hours
    }

    /**
     * Retrieve a value from Redis
     *
     * @param string $type The datatype
     * @param string $key The key
     * @return mixed|NULL  The value
     */
    public function get($type, $key)
    {
        $redisKey = $this->prefix . $type . $key;
        $value = $this->redis->get($redisKey);
        if (!$value) {
            return null;
        }

        return unserialize($value);
    }

    /**
     * Save a value to Redis
     *
     * If no expiration time is given, then the expiration time is set to the
     * session duration.
     *
     * @param string $type The datatype
     * @param string $key The key
     * @param mixed $value The value
     * @param int|NULL $expire The expiration time (unix timestamp), or NULL if it never expires
     */
    public function set($type, $key, $value, $expire = null)
    {
        $redisKey = $this->prefix . $type . $key;
        if (null === $expire && $this->lifeTime) {
            $expire = time() + $this->lifeTime;
        }
        if ($expire) {
            $this->redis->set($redisKey, serialize($value), 'EX', $expire);
        } else {
            $this->redis->set($redisKey, serialize($value));
        }
    }

    /**
     * Delete a value from Redis
     *
     * @param string $type The datatype
     * @param string $key The key
     */
    public function delete($type, $key)
    {
        $redisKey = $this->prefix . $type . $key;
        $this->redis->del($redisKey);
    }
}
