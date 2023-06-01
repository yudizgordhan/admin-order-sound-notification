<?php
/**
 * UpgradeSchema
 *
 * @copyright Copyright © 2023 Ushop Unilever. All rights reserved.
 * @author    ahmed.allam@unilever.com
 */

namespace Yudiz\Ordernotification\Setup;


use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @inheritdoc
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {

        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.3.0', '<'))
        {
            $setup->getConnection()->addColumn(
                $setup->getTable('yudiz_ordernotification'),
                'user_id',
                [
                    'type' => Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => false,
                    'comment' => 'Notified user id'
                ]
            );
        }

        $setup->endSetup();
    }
}
