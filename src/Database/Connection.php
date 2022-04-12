<?php
namespace Src\Database;

use mysqli;

interface Connection
{
    public function connection(): mysqli;
}