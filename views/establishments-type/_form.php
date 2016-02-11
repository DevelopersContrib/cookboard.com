<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EstablishmentsType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="establishments-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nam')->textInput(['maxlength' => 128]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
