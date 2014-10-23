<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MessagesModelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="messages-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'from_user_id') ?>

    <?= $form->field($model, 'to_user_id') ?>

    <?= $form->field($model, 'to_all_user') ?>

    <?= $form->field($model, 'subject') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'datetime_created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
