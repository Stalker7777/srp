<?php

/** @var yii\web\View $this */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

if($is_login) {
    $this->title = 'Авторизация';
} else {
    $this->title = 'Регистрация';
}

$this->params['breadcrumbs'][] = $this->title;
?>

<?php if($is_login) { ?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            
            <?= $form->field($login, 'phone')->textInput(['autofocus' => true]) ?>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <?= Html::submitButton('Авторизоваться', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-right">
                            <?= Html::a('Регистрация', ['/site/loginsignup', 'is_login' => false]); ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php } else { ?>

<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
    
            <?= $form->field($signup, 'phone')->textInput(['autofocus' => true]) ?>

            <?= $form->field($signup, 'username')->textInput() ?>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <?= Html::submitButton('Зарегистироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-right">
                            <?= Html::a('Авторизация', ['/site/loginsignup', 'is_login' => true]); ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php } ?>

<?php
/*
    $is_login_show = $is_login ? 1 : 0;

$js = <<< JS

    var is_login = $is_login_show;

    $('document').ready(function() {
        
        if(is_login == 1) {
            $('#site-login').show();
        }
        else {
            $('#site-signup').show();
        }
        
    });

JS;

$this->registerJs( $js, $position = yii\web\View::POS_END);
*/
?>