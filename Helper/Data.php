<?php

namespace Yudiz\Ordernotification\Helper;

/**
 * Ordernotification Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Section name for configs
     */
    const SECTION_ID = 'ordernotification/';
    const DELAY_TIME = 15000; // millisecond: 15 seconds


    public function getConfig($configPath, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::SECTION_ID . $configPath,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORES,
            $storeId
        );
    }

    /**
     * @return bool
     */
    public function moduleEnabled(): bool
    {
        return (bool)$this->getConfig('general/enable');
    }

    public function getAudioFile()
    {
        return $this->getConfig('general/audio_file_upload');
    }

    public function getSoundType()
    {
        return $this->getConfig('general/audio_type');
    }

    public function getDelay(): int
    {
        return (int) $this->getConfig('general/delay_time') ?? self::DELAY_TIME;
    }
}
