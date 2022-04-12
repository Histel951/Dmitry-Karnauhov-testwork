<?php

use Src\Modules\CalculateDeliveryPrice\Services\Delivery\DeliveryFactory;

require_once "vendor/autoload.php";

$fast = (new DeliveryFactory)->slow();

echo '<pre>';
echo $fast->json();