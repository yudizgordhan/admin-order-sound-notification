<?php
namespace Yudiz\Ordernotification\Block\Adminhtml;


class OrderAlert extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Yudiz\Ordernotification\Helper\Data
     */
    protected $dataHelper;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Yudiz\Ordernotification\Helper\Data $dataHelper
    ) {
        $this->dataHelper = $dataHelper;
        parent::__construct($context);
    }

    public function isEnabled()
    {
        return $this->dataHelper->moduleEnabled();
    }

    public function getSoundFile()
    {
        return $this->dataHelper->getAudioFile();
    }

    public function getSoundType()
    {
        return $this->dataHelper->getSoundType();
    }

    public function getDelay() :int
    {
        return $this->dataHelper->getDelay();
    }

    public function getMediaUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        ) . 'order_sound/';
    }
}
