<?php
namespace Src\Database\Models;

use Src\Database\DB;
use mysqli_result;

abstract class Model
{
    protected string $table = '';

    public function add(array $data): mysqli_result|bool
    {
        $fields_sql = [];
        $values_sql = [];
        foreach ($data as $field => $value)
        {
            $fields_sql[] = $field;
            $values_sql[] = $value;
        }

        return DB::connection()->query("
            insert into
                {$this->table} ({$this->arrayImplodeSql($fields_sql)})
            values 
                ({$this->arrayImplodeSql($values_sql)});
            ");
    }

    public function find(int|string $value, string $field = 'id'): mysqli_result|bool
    {
        return DB::connection()->query("select * from {$this->table} where '{$field}' = {$this->valueSqlFormat($value)}");
    }

    public function findWhereEquals(array $data): mysqli_result|bool
    {
        $where = 'where';
        foreach ($data as $field => $value)
        {
            if (array_key_first($data) === $field) {
                $where .= " {$field}={$this->valueSqlFormat($value)}";
                continue;
            }

            if (array_key_last($data) !== $field) {
                $where .= " AND {$field}={$this->valueSqlFormat($value)}";
            } else {
                $where .= " AND {$field}={$this->valueSqlFormat($value)}";
            }
        }

        return DB::connection()->query("select * from {$this->table} {$where};");
    }

    public function update(int $id, array $data): bool
    {
        $set = '';
        foreach ($data as $field => $value) {
            if (array_key_last($data) !== $field) {
                $set .= "{$field}={$this->valueSqlFormat($value)},";
            } else {
                $set .= "{$field}={$this->valueSqlFormat($value)}";
            }
        }

        return DB::connection()->query("update {$this->table} set $set");
    }

    public function delete(int $id, string $idExtName = 'id'): bool
    {
        return DB::connection()->query("delete from {$this->table} where {$idExtName} = {$id}");
    }

    /**
     * Возвращает строку значений для SQL запроса через ","
     * @param array $values
     * @return string
     */
    private function arrayImplodeSql(array $values): string
    {
        return implode(',', $values);
    }

    /**
     * Возвращает значение в формате для SQL
     * @param string|int $value
     * @return string|int
     */
    private function valueSqlFormat(string|int $value): string|int
    {
        if (!is_int($value)) {
            $value = "'{$value}'";
        }

        return $value;
    }

    private function buildEqualsWhere(string $field, string|int $value, array $data, string &$where, $key)
    {
        if (array_key_first($data) === $field and $key === 0) {
            $where .= " {$field}={$this->valueSqlFormat($value)}";
            return;
        }

        if (array_key_last($data) !== $field) {
            $where .= " AND {$field}={$this->valueSqlFormat($value)}";
        } else {
            $where .= " AND {$field}={$this->valueSqlFormat($value)}";
        }
    }

    private function buildORWhere(string $field, string|int $value, array $data, string &$where, $key)
    {
        if (array_key_first($data) === $field and $key === 0) {
            $where .= " {$field}={$this->valueSqlFormat($value)}";
            return;
        }

        if (array_key_last($data) !== $field) {
            $where .= " OR {$field}={$this->valueSqlFormat($value)}";
        } else {
            $where .= " OR {$field}={$this->valueSqlFormat($value)}";
        }
    }
}
