<?php
namespace Src\Database;

use mysqli;
use Src\Config\Config;

abstract class AbstractConnection implements Connection
{
    /**
     * Название класса конфига для БД
     * @var Config|string
     */
    protected Config|string $config_class;

    /**
     * Массив обязательных параметров в конфигах
     */
    private const REQUIRED_CONNECTION_PARAMS = [
        'host',
        'user',
        'password',
        'database'
    ];

    private string $not_exist_config_name;

    /**
     * Инстанс текущего объекта
     * @var array
     */
    private static array $_instance;

    private mysqli $connection;

    /**
     * @throws ConnectionException
     */
    private function __construct()
    {
        $configs = (new $this->config_class)->getConfigs();

        if ($this->validateConfigs($configs)) {
            $this->connection = new mysqli(
                $configs['host'],
                $configs['user'],
                $configs['password'],
                $configs['database']
            );
        } else {
            throw new ConnectionException("Config \"{$this->not_exist_config_name}\" is not exist.", 2000);
        }
    }

    /**
     * Возвращает текущее подключение к базе
     * @return mysqli
     */
    public function connection(): mysqli
    {
        return $this->connection;
    }

    /**
     * @return static
     */
    public static function getInstance(): static
    {
        $class = self::class;
        if (empty(self::$_instance[$class])) {
            self::$_instance[$class] = new static();
        }

        return self::$_instance[$class];
    }

    /**
     * Проверка есть ли в массиве конфигов обязательные параметры
     * @param array $configs
     * @return bool
     */
    private function validateConfigs(array $configs): bool
    {
        $keys = array_keys($configs);
        foreach ($keys as $key)
        {
            if (!in_array($key, self::REQUIRED_CONNECTION_PARAMS)) {
                $this->not_exist_config_name = $key;
                return false;
            }
        }

        return true;
    }
}