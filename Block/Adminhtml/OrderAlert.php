<?php
namespace Ydz\Ordernotification\Block\Adminhtml;

class OrderAlert extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Ydz\Ordernotification\Helper\Data
     */
    protected $dataHelper;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Ydz\Ordernotification\Helper\Data $dataHelper
    ) {
        $this->dataHelper = $dataHelper;
        parent::__construct($context);
    }

    public function getEnable()
    {
        if (!$this->dataHelper->moduleEnabled()) {
            return '';
        }

        return true;
    }

    public function getSoundFile()
    {
        return $this->dataHelper->getAudioFile();
    }

    public function getSoundType()
    {
        return $this->dataHelper->getSoundType();
    }

    public function getDealy()
    {
        return $this->dataHelper->getDealy();
    }

    public function getMediaUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        ) . 'order_sound/';
    }
}
