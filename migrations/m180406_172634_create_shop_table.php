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
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('shop');
    }
}
