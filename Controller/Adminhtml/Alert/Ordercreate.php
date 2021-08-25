<?php
namespace Yudiz\Ordernotification\Controller\Adminhtml\Alert;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class Ordercreate extends Action
{
    protected $logger;
    protected $collectionFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Yudiz\Ordernotification\Model\ResourceModel\Ordernotification\CollectionFactory $collectionFactory,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->logger = $logger;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {

        $data = [
            'success' => 200,
            'message' => __("Play sound"),
        ];
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $orderDatamodel = $objectManager->get(\Magento\Sales\Model\Order::class)->getCollection()->getLastItem();
        $orderId = $orderDatamodel->getId();

        $collection = $this->collectionFactory->create();
        $orderNotificationFirstItem = $collection->getFirstItem();

        $text = "";
        $text = "New order " . $orderDatamodel->getIncrementId() . " placed by ";
        $text .= $orderDatamodel->getCustomerFirstname() . " " . $orderDatamodel->getCustomerLastname();
        $data['message'] = $text;

        if ($orderNotificationFirstItem) {
            if ($orderNotificationFirstItem->getOrderId() == $orderId) {
                $data['success'] = 413;
                $data['message'] = __("Not Play sound");
            } else {
                if ($orderDatamodel->getStatus() == 'payment_review' || $orderDatamodel->getStatus() == 'pending_payment') {
                    $data['success'] = 413;
                    $data['message'] = __("Not Play sound, payment remain");
                } else {
                    $orderNotificationFirstItem->setOrderId($orderId);
                    $orderNotificationFirstItem->setCreatedTime(date('Y-m-d H:i:s'));
                    $orderNotificationFirstItem->save();
                    $data['success'] = 200;
                    $data['message'] = $text;

                    // For log order data and order ID
                    // $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/ordernotification.log');
                    // $logger = new \Zend\Log\Logger();
                    // $logger->addWriter($writer);
                    // $logger->info(json_encode(["data" => $data, 'orderId' => $orderId]));
                }

            }
        }

        //Send response to Ajax query
        //$data = $orderId;
        $result = $this->resultJsonFactory->create();
        return $result->setData($data);
    }
}
