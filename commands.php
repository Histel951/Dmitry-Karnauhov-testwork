<?php

use Src\Config\AppConfig;
use Src\Database\DatabaseSettings;

require_once "vendor/autoload.php";

switch ($argv[1]) {
    case 'migrate': {
        // для апдейта всех таблиц без проверки на внешние ключи
        DatabaseSettings::foreignKeyCheck(false);

        $app_conf = new AppConfig();
        $migrations = $app_conf->getConfigs()['migrations']['entities'];
        foreach ($migrations as $migration)
        {
            $class_instance = new $migration();
            if ($class_instance->run()) {
                echo $class_instance->tableQuery()."\n";
            }
        }
        DatabaseSettings::foreignKeyCheck(true);
        break;
    }

    default: {
        throw new Exception('command not found');
    }
}