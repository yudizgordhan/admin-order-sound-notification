<?php
namespace Yudiz\Ordernotification\Model;

class Ordernotification extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * Test cache tag
     */
    const CACHE_TAG = 'order_notificationy';

    /**
     * @var string
     */
    protected $_cacheTag = 'order_notificationy';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'order_notificationy';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Yudiz\Ordernotification\Model\ResourceModel\Ordernotification::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [
            self::CACHE_TAG . '_' . $this->getId(),
            self::CACHE_TAG . '_' . $this->getId()
        ];
    }

    /**
     * Prepare item's statuses
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [
            self::STATUS_ENABLED => __('Enabled'),
            self::STATUS_DISABLED => __('Disabled')
        ];
    }
}
