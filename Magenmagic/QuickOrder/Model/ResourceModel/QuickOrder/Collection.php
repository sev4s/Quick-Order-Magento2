<?php

namespace Magenmagic\QuickOrder\Model\ResourceModel\QuickOrder;

use Magenmagic\QuickOrder\Model\QuickOrder as QuickOrderModel;
use Magenmagic\QuickOrder\Model\ResourceModel\QuickOrder as QuickOrderResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(QuickOrderModel::class, QuickOrderResource::class);
    }
}
