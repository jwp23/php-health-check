<?php

namespace BB\WPHealthCheck\Tests\unit\Mocks;

/**
 * Class MysqliMock provides a mock of \mysqli class since \mysqli class
 * properties are not writable, which makes them unmockable. Resource
 * https://bugs.php.net/bug.php?id=63591
 *
 * @package BB\WPHealthCheck\Tests\unit\Mocks
 */
class MysqliMock
{

    public $mysqli;

    /**
     * MysqliMock constructor.
     */
    public function __construct()
    {
        $this->mysqli = new \mysqli();
    }

    /**
     * Sets that any calls to this object's properties will return the
     * properties of $this->mysqli
     *
     * @param $method
     * @param $args
     */
    public function __call($method, $args)
    {
        call_user_func_array(array($this->mysqli, $method), $args);
    }

    /**
     * Retrieves the properties of \mysqli that we've mocked
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        if ($name === 'connect_error') {
            return $this->connect_error;
        }

        return $this->mysqli->$name;
    }

    /**
     * Sets the properties of \mysqli that we want to mock onto this object.
     * Any properties that we want to mock must also be specified in __get() to
     * return when we try to retrieve.
     *
     * @param string $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if ($name === 'connect_error') {
            $this->connect_error = $value;
        }
    }
}
