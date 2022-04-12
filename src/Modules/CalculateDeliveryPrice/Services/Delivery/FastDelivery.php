<?php
namespace Src\Modules\CalculateDeliveryPrice\Services\Delivery;

use Src\Modules\CalculateDeliveryPrice\Services\Delivery\Elements\AbstractDeliveryElement;
use Src\Modules\CalculateDeliveryPrice\Services\Delivery\Elements\FastDeliveryElement;

class FastDelivery extends AbstractDelivery
{
    /**
     * Ид компании в базе (эмуляция)
     * @var int
     */
    private int $company_id = 1;

    /**
     * Класс зависимости от элемента доставки для инициализации
     * @var string
     */
    protected string $element_class = FastDeliveryElement::class;

    protected function formatJson(AbstractDeliveryElement $element): array
    {
        return [
            'price' => $element->price,
            'period' => $element->delivery_date,
            'error' => $element->error
        ];
    }

    protected function getCompanyId(): int
    {
        return $this->company_id;
    }
}