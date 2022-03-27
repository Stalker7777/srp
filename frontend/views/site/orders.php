<?php

/** @var yii\web\View $this */

use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use frontend\models\Orders;

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">
    
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'date',
                'format' => 'raw',
                'value' => function ($data) {
                    return date("d.m.Y", $data['date']);
                }
            ],
            'number',
            'amount',
            'status',
        ],
    ]); ?>

</div>