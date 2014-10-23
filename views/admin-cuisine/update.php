<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cuisine */

$this->title = 'Update Cuisine: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Cuisines', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cuisine-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
