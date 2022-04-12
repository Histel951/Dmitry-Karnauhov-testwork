<?php
namespace Src\Database;

use Src\Config\Config;
use Src\Config\DatabaseConfig;

class MysqlConnection extends AbstractConnection
{
    protected Config|string $config_class = DatabaseConfig::class;
}