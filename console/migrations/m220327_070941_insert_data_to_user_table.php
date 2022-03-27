<?php

use yii\db\Migration;

/**
 * Class m220327_070941_insert_data_to_user_table
 */
class m220327_070941_insert_data_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $data = [
            ['id' => 1, 'phone' => '87756407825', 'username' => 'username 1',],
            ['id' => 2, 'phone' => '87756407826', 'username' => 'username 2',],
            ['id' => 3, 'phone' => '87756407827', 'username' => 'username 3',],
            ['id' => 4, 'phone' => '87756407828', 'username' => 'username 4',],
            ['id' => 5, 'phone' => '87756407829', 'username' => 'username 5',],
        ];
        
        foreach ($data as $item) {
            $date = date("Y-m-d H:i:s");
            $period = strtotime($date . " + 2 day");
    
            $this->insert('{{%user}}', [
                'id' => $item['id'],
                'phone' => $item['phone'],
                'username' => $item['username'],
                'password' => Yii::$app->security->generateRandomString(14),
                'period' => $period,
                'created_at' => time(),
                'updated_at' => time(),
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $ids = range(1, 5, 1);
        
        foreach ($ids as $id) {
            $this->delete('{{%user}}', ['id' => $id]);
        }
    }

}
