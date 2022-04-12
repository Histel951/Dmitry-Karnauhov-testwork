<?php
namespace Src\Database\Migrations;

use Src\Config\AppConfig;
use Src\Config\Config;
use Src\Database\DB;

use mysqli_result;

abstract class Migration
{
    protected string $table_name;

    protected Config $app_configs;

    public function __construct()
    {
        $this->app_configs = new AppConfig();
    }

    /**
     * Возвращает структура таблицы в запросе sql
     * @var string
     */
    abstract public function tableQuery(): string;

    /**
     * Запускает миграцию
     * @return mysqli_result|bool
     */
    public function run(): mysqli_result|bool
    {
        if ($this->app_configs->getConfigs()['migrations']['fresh'] and $this->table_name) {
            $this->drop();
        }

        return DB::connection()->query($this->tableQuery());
    }

    /**
     * Дропает таблицу в базе если проставлена настройка на обновление
     * @return bool
     */
    private function drop(): bool
    {
        return DB::connection()->query("DROP TABLE {$this->table_name}");
    }
}