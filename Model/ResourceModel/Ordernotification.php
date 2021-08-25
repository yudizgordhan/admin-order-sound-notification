<?php
namespace Yudiz\Ordernotification\Model\ResourceModel;

class Ordernotification extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    protected function _construct()
    {
        $this->_init(
            'yudiz_ordernotification',
            'ordernotification_id'
        );
    }
}
