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

namespace Yudiz\Ordernotification\Helper;

/**
 * Ordernotification Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Section name for configs
     */
    public const SECTION_ID = 'ordernotification';
    public const DEALY_TIME = 15000; // mili second: 15 seconds

    /**
     * @var string
     */
    protected $_configSectionId = 'ordernotification';

    /**
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     *
     * @var \Magento\Framework\App\Helper\Context
     */
    protected $_scopeConfig;

    /**
     * Constructor
     *
     * @param  \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Registry $registry
    ) {
        $this->_scopeConfig = $context->getScopeConfig();
        $this->_configSectionId = self::SECTION_ID;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * Get configuration value for the given path
     *
     * @param string $configPath Path to the configuration
     * @return mixed Configuration value
     */
    public function getConfig($configPath)
    {
        return $this->scopeConfig->getValue(
            $configPath,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Check if the module is enabled
     *
     * @return string|bool
     */
    public function moduleEnabled(): bool
    {
        return (bool) $this->getConfig($this->_configSectionId . '/general/enable');
    }

    /**
     * Get the audio file
     *
     * @return string
     */
    public function getAudioFile()
    {

        return $this->getConfig($this->_configSectionId . '/general/audio_file_upload');
    }

    /**
     * Get the sound type
     *
     * @return string
     */
    public function getSoundType()
    {

        return $this->getConfig($this->_configSectionId . '/general/audio_type');
    }

    /**
     * Get delay time
     *
     * @return string
     */
    public function getDelay()
    {
        return self::DEALY_TIME;
    }
}
