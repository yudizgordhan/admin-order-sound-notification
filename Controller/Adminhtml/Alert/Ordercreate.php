<?php
namespace Yudiz\Ordernotification\Controller\Adminhtml\Alert;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class Ordercreate extends Action
{
    protected $collectionFactory;
    protected $orderCollectionFactory;
    protected $orderNotificationFactory;
    protected $authSession;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Yudiz\Ordernotification\Model\ResourceModel\Ordernotification\CollectionFactory $collectionFactory,
        \Yudiz\Ordernotification\Model\OrdernotificationFactory $orderNotificationFactory,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Backend\Model\Auth\Session $authSession
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->collectionFactory = $collectionFactory;
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->orderNotificationFactory = $orderNotificationFactory;
        $this->authSession = $authSession;
    }

    /**
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
        if($orderCollection->getSize()){
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
