<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Messages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="messages-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'from_user_id')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'to_user_id')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'to_all_user')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'subject')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'datetime_created')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
