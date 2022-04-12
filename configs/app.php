<?php
return [
    'migrations' => [
        'fresh' => true,
        'entities' => [
            \Src\Database\Migrations\CompaniesMigration::class,
            \Src\Database\Migrations\DeliveryElementsMigration::class
        ]
    ]
];