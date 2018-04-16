<?php

use yii\db\Migration;

/**
 * Handles the creation of table `business_hours`.
 * Has foreign keys to the tables:
 *
 * - `shop`
 */
class m180407_153507_create_business_hours_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('business_hours', [
            'id' => $this->primaryKey(),
            'shop_id' => $this->integer()->notNull(),
            'weekday' => 'tinyint not null',
            'start_hour' => $this->time()->notNull(),
            'close_hour' => $this->time()->notNull(),
        ]);

        // creates index for column `shop_id`
        $this->createIndex(
            'idx-business_hours-shop_id',
            'business_hours',
            'shop_id'
        );

        // add foreign key for table `shop`
        $this->addForeignKey(
            'fk-business_hours-shop_id',
            'business_hours',
            'shop_id',
            'shop',
            'id',
            'CASCADE'
        );


        // creates index for column `weekday`, to improve the query performance.
        $this->createIndex(
            'idx-business_hours-weekday',
            'business_hours',
            'weekday'
        );

        // creates index for column `start_hour`, to improve the query performance.
        $this->createIndex(
            'idx-business_hours-start_hour',
            'business_hours',
            'start_hour'
        );

        // creates index for column `close_hour`, to improve the query performance.
        $this->createIndex(
            'idx-business_hours-close_hour',
            'business_hours',
            'close_hour'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `shop`
        $this->dropForeignKey(
            'fk-business_hours-shop_id',
            'business_hours'
        );

        // drops index for column `shop_id`
        $this->dropIndex(
            'idx-business_hours-shop_id',
            'business_hours'
        );

        $this->dropTable('business_hours');
    }
}
