<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserModelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-model-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'password') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'datetime_created') ?>

    <?php // echo $form->field($model, 'authKey') ?>

    <?php // echo $form->field($model, 'auth_key') ?>

    <?php // echo $form->field($model, 'notes') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
