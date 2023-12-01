<?php

/**
 * Yudiz
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Yudiz
 * @package     Yudiz_Ordernotification
 * @copyright   Copyright (c) 2023 Yudiz (https://www.Yudiz.com/)
 */

namespace Yudiz\Ordernotification\Model\ResourceModel\Ordernotification;

use Yudiz\Ordernotification\Model\ResourceModel\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'ordernotification_id';

    /**
     * @var mixed
     */
    protected $_previewFlag;

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init(
            \Yudiz\Ordernotification\Model\Ordernotification::class,
            \Yudiz\Ordernotification\Model\ResourceModel\Ordernotification::class
        );

        $this->_map['fields']['ordernotification_id'] = 'main_table.ordernotification_id';
    }
}
