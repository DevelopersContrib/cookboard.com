<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CookBoard */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cook-board-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'datetime_created')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'featured')->textInput() ?>

    <?= $form->field($model, 'image')->textInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
