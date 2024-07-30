<?php

namespace Magenmagic\QuickOrder\Model;

use Magenmagic\QuickOrder\Model\ResourceModel\QuickOrder as QuickOrderResource;
use Magento\Framework\Model\AbstractModel;

class QuickOrder extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(QuickOrderResource::class);
    }
}
