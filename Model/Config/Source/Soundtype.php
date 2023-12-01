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

namespace Yudiz\Ordernotification\Model\Config\Source;

class Soundtype implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Get options for sound type.
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'sound', 'label' => 'Play sound'],
            ['value' => 'speech', 'label' => 'Play speech'],
        ];
    }
}
