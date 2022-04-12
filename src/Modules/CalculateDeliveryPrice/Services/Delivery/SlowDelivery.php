<?php
namespace Src\Modules\CalculateDeliveryPrice\Services\Delivery;

use Src\Modules\CalculateDeliveryPrice\Services\Delivery\Elements\AbstractDeliveryElement;
use Src\Modules\CalculateDeliveryPrice\Services\Delivery\Elements\SlowDeliveryElement;

class SlowDelivery extends AbstractDelivery
{
    /**
     * Ид компании в базе (эмуляция)
     * @var int
     */
    private int $company_id = 2;

    /**
     * Класс зависимости от элемента доставки для инициализации
     * @var string
     */
    protected string $element_class = SlowDeliveryElement::class;

    protected function formatJson(AbstractDeliveryElement $element): array
    {
        return [
            'coefficient' => $element->price,
            'date' => $element->delivery_date,
            'error' => $element->error
        ];
    }

    protected function getCompanyId(): int
    {
        return $this->company_id;
    }
}