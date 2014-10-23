<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BoardEntryModelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="board-entry-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'datetime_created') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'cuisine_id') ?>

    <?php // echo $form->field($model, 'course_id') ?>

    <?php // echo $form->field($model, 'diet_id') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'rating') ?>

    <?php // echo $form->field($model, 'delivery_type_id') ?>

    <?php // echo $form->field($model, 'price') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
