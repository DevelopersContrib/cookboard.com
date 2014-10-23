<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Diet */

$this->title = 'Create Diet';
$this->params['breadcrumbs'][] = ['label' => 'Diets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="diet-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
