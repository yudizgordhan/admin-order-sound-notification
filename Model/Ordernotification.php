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

namespace Yudiz\Ordernotification\Model;

class Ordernotification extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Statuses
     */
    public const STATUS_ENABLED = 1;
    public const STATUS_DISABLED = 0;

    /**
     * Test cache tag
     */
    public const CACHE_TAG = 'order_notificationy';

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
     * Initialize resource model
     *
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
