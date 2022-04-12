<?php
namespace Src\Database\Migrations;

class CompaniesMigration extends Migration
{
    protected string $table_name = 'companies';

    public function tableQuery(): string
    {
        return "create table {$this->table_name} (
                    id int not null AUTO_INCREMENT,
                    name varchar(255),
                    source_from varchar(255) not null,
                    target_to varchar(255) not null,
                    weight integer(11) not null,
                    primary key (id)
                );";
    }
}