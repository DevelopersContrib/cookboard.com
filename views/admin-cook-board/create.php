<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CookBoard */

$this->title = 'Create Cook Board';
$this->params['breadcrumbs'][] = ['label' => 'Cook Boards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cook-board-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
