<?php
namespace Src\Database;

use Src\Config\ConnectionsConfig;

use mysqli;

class DB
{
    public static function connection(string $name = ''): mysqli
    {
        $configs = (new ConnectionsConfig())->getConfigs();
        if ($name) {
            $connection = $configs[$name];
        } else {
            $connection = $configs['default'];
        }

        return $connection::getInstance()->connection();
    }
}