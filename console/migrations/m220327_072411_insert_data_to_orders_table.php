<?php

use yii\db\Migration;

/**
 * Class m220327_072411_insert_data_to_orders_table
 */
class m220327_072411_insert_data_to_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user_ids = range(1, 5, 1);
        $current_id = 1;
        
        foreach ($user_ids as $user_id) {
            
            $numbers = range(1000, 1100, 1);
            
            foreach ($numbers as $number) {
    
                $this->insert('{{%orders}}', [
                    'id' => $current_id,
                    'users_id' => $user_id,
                    'date' => time(),
                    'number' => $number,
                    'amount' => random_int(1000, 10000),
                    'status' => 0,
                ]);
    
                $current_id++;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%orders}}', ['>', 'id', 0]);
    }
}
