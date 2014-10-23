<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PriceType */

$this->title = 'Create Price Type';
$this->params['breadcrumbs'][] = ['label' => 'Price Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="price-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
