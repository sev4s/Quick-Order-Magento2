<?php

namespace Magenmagic\QuickOrder\Model;

use Magenmagic\QuickOrder\Model\QuickOrderFactory;
use Magenmagic\QuickOrder\Model\ResourceModel\QuickOrder as QuickOrderResource;

class QuickOrderRepository
{
    /**
     * @var QuickOrderResource
     */
    private $quickOrderResource;

    /**
     * @var QuickOrderFactory
     */
    private $quickOrderFactory;

    public function __construct(
        QuickOrderResource $quickOrderResource,
        QuickOrderFactory  $quickOrderFactory
    )
    {
        $this->quickOrderResource = $quickOrderResource;
        $this->quickOrderFactory = $quickOrderFactory;
    }

    public function getById(int $quickOrderId): QuickOrder
    {
        $quickOrder = $this->quickOrderFactory->create();

        $this->quickOrderResource->load($quickOrder, $quickOrderId);

        return $quickOrder;
    }

    public function save(QuickOrder $quickOrder): QuickOrder
    {
        $this->quickOrderResource->save($quickOrder);

        return $quickOrder;
    }

    public function deleteById(int $quickOrderId): void
    {
        $quickOrder = $this->quickOrderFactory->create();

        $this->quickOrderResource->load($quickOrder, $quickOrderId);

        $this->quickOrderResource->delete($quickOrder);
    }
}
