<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders}}`.
 */
class m220327_065725_create_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'users_id' => $this->integer()->notNull(),
            'date' => $this->timestamp()->notNull(),
            'number' => $this->integer()->notNull(),
            'amount' => $this->double()->notNull(),
            'status' => $this->integer()->notNull(),
        ], $tableOptions);
        
        $this->createIndex('index-users_id', '{{%orders}}', 'users_id');
        
        $this->addForeignKey('fk-orders-users_id-to-users-id', '{{%orders}}', 'users_id', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-orders-users_id-to-users-id', '{{%orders}}');
        
        $this->dropIndex('index_users_id', '{{%orders}}');
        
        $this->dropTable('{{%orders}}');
    }
}
