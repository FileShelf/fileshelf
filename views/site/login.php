<?php

/* @var $this app\components\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model app\models\form\LoginForm */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Login';
?>
<div class="card">
    <div class="card-body">
        <h1 class="card-title text-center"><?= Html::encode($this->title) ?></h1>

        <div class="card-text">

            <?php
            $form = ActiveForm::begin([
                'id'          => 'loginForm',
                'layout'      => 'horizontal',
                'fieldConfig' => [
                    'template'     => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-lg-16\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-2 control-label'],
                ],
            ]);
            echo $form->field($model, 'username')->textInput(['autofocus' => true]);
            echo $form->field($model, 'password')->passwordInput();
            echo $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"offset-lg-2 col-lg-6\">{input} {label}</div>\n<div class=\"col-lg-16\">{error}</div>",
            ]) ?>

            <div class="form-group">
                <div class="offset-lg-2 col-lg-22">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-block btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
