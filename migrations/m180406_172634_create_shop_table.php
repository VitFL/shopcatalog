<?php

use yii\db\Migration;

/**
 * Handles the creation of table `shop`.
 */
class m180406_172634_create_shop_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('shop', [
            'id' => $this->primaryKey(),
            'shop_name' => $this->string()->notNull(),
            'shop_description' => $this->string()->notNull(),
            'shop_address' => $this->string()->notNull(),
        ]);

        // creates index for column `shop_name`, to improve the query performance.
        $this->createIndex(
            'idx-shop-shop_name',
            'shop',
            'shop_name'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('shop');
    }
}
