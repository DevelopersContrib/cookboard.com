<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 128]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 128]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 128]) ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'datetime_created')->textInput() ?>

    <?= $form->field($model, 'authKey')->textInput(['maxlength' => 128]) ?>

    <?= $form->field($model, 'notes')->textInput(['maxlength' => 128]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
