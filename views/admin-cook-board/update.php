<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CookBoard */

$this->title = 'Update Cook Board: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Cook Boards', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cook-board-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
