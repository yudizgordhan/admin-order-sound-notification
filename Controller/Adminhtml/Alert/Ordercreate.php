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

namespace Yudiz\Ordernotification\Controller\Adminhtml\Alert;

use Magento\Backend\App\Action;

class Ordercreate extends Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var \Yudiz\Ordernotification\Model\ResourceModel\Ordernotification\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var\Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    protected $orderCollectionFactory;

    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $authSession;
    /**
     * @var\Yudiz\Ordernotification\Model\OrdernotificationFactory

     */
    protected $orderNotificationFactory;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Yudiz\Ordernotification\Model\ResourceModel\Ordernotification\CollectionFactory $collectionFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
     * @param  \Magento\Backend\Model\Auth\Session $authSession
     * @param  \Yudiz\Ordernotification\Model\OrdernotificationFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Yudiz\Ordernotification\Model\ResourceModel\Ordernotification\CollectionFactory $collectionFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Yudiz\Ordernotification\Model\OrdernotificationFactory $orderNotificationFactory
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->logger = $logger;
        $this->collectionFactory = $collectionFactory;
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->authSession = $authSession;
        $this->orderNotificationFactory = $orderNotificationFactory;
    }

    /**
     * Execute the action.
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $data = [
            'success' => 413,
            'message' => __("Already notified, Don't play sound"),
        ];
        $orderCollection = $this->orderCollectionFactory->create();
        $orderCollection->getSelect()->order('entity_id DESC')->limit('1');
        if ($orderCollection->getSize()) {
            $orderDatamodel = $orderCollection->getFirstItem();
            $orderId = $orderDatamodel->getId();
            $userId = $this->authSession->getUser()->getId();
            $isNotified = $this->collectionFactory->create()
                ->addFieldToFilter('order_id', $orderId)
                ->addFieldToFilter('user_id', $userId)
                ->getSize();

            if (!$isNotified) {
                if ($orderDatamodel->getStatus() == 'payment_review' || $orderDatamodel->getStatus() == 'pending_payment') {
                    $data['success'] = 413;
                    $data['message'] = __("Not Play sound, payment remain");
                } else {
                    $orderNotification = $this->orderNotificationFactory->create();
                    $orderNotification->setOrderId($orderId)
                        ->setUserId($userId)
                        ->setCreatedTime(date('Y-m-d H:i:s'));
                    $orderNotification->save();
                    $data['success'] = 200;
                    $data['message'] = __("New order %1 place by %2", $orderDatamodel->getIncrementId(), $orderDatamodel->getCustomerFirstname() . " " . $orderDatamodel->getCustomerLastname());
                }
            }
        }
        $result = $this->resultJsonFactory->create();
        return $result->setData($data);
    }
}
