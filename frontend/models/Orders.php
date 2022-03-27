<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $users_id
 * @property int $date
 * @property int $number
 * @property float $amount
 * @property int $status
 *
 * @property User $users
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['users_id', 'date', 'number', 'amount', 'status'], 'required'],
            [['users_id', 'date', 'number', 'status'], 'integer'],
            [['amount'], 'number'],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['users_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'users_id' => 'Users ID',
            'date' => 'Дата',
            'number' => '№ заказа',
            'amount' => 'Сумма',
            'status' => 'Статус',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(User::className(), ['id' => 'users_id']);
    }
}
