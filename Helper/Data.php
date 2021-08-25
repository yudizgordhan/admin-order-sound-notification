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
    const SECTION_ID = 'ordernotification';
    const DEALY_TIME = 15000; // mili second: 15 seconds

    protected $_configSectionId = 'ordernotification';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @param Context $context
     * @param array $data
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

    public function getConfig($configPath)
    {
        return $this->scopeConfig->getValue(
            $configPath,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return bool
     */
    public function moduleEnabled(): bool
    {
        return (bool) $this->getConfig($this->_configSectionId . '/general/enable');
    }

    public function getAudioFile()
    {

        return $this->getConfig($this->_configSectionId . '/general/audio_file_upload');
    }

    public function getSoundType()
    {

        return $this->getConfig($this->_configSectionId . '/general/audio_type');
    }

    public function getDealy()
    {

        return self::DEALY_TIME;
        //return $this->getConfig($this->_configSectionId . '/general/audio_file_upload');
    }
}
