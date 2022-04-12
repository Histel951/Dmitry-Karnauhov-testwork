<?php
namespace Src\Database;

class DatabaseSettings
{
    /**
     * Выключает/выключает проверку на внешние ключи
     * @param bool $enable
     * @return void
     */
    public static function foreignKeyCheck(bool $enable): void
    {
        if ($enable) {
            DB::connection()->query("SET foreign_key_checks = 1;");
        } else {
            DB::connection()->query("SET foreign_key_checks = 0;");
        }
    }
}