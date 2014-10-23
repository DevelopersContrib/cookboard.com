<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper; // load classes
/* @var $this yii\web\View */
/* @var $model app\models\BoardEntry */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="board-entry-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'datetime_created')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'cuisine_id')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'course_id')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'diet_id')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => 128]) ?>

    <?= $form->field($model, 'rating')->textInput() ?>

    <?= $form->field($model, 'delivery_type_id')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'price')->textInput() ?>
    <?//= $form->field($model, 'course_id')->dropDownList(ArrayHelper::map(app\models\Course::find()->all(), 'id', 'name')) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
