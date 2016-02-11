<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EstablishmentsType */

$this->title = 'Update Establishments Type: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Establishments Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="establishments-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
