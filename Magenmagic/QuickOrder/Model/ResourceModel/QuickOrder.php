<?php

namespace Magenmagic\QuickOrder\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class QuickOrder extends AbstractDb
{
    public const TABLE_NAME = 'magenmagic_quick_order';

    public const ID_FIELD_NAME = 'quick_order_id';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self::ID_FIELD_NAME);
    }
}
