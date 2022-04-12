<?php
namespace Src\Database\Migrations;

class DeliveryElementsMigration extends Migration
{
    protected string $table_name = 'delivery_elements';

    public function tableQuery(): string
    {
        return "create table {$this->table_name} (
                    id int not null AUTO_INCREMENT,
                    name varchar(255) not null,
                    price float(11) default 0,
                    date date not null,
                    company_id int(11) not null,
                    primary key (id),
                    foreign key (company_id) references companies(id)
                );";
    }
}