<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Cuisine */

$this->title = 'Create Cuisine';
$this->params['breadcrumbs'][] = ['label' => 'Cuisines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cuisine-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
