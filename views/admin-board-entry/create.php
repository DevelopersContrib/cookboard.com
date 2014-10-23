<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BoardEntry */

$this->title = 'Create Board Entry';
$this->params['breadcrumbs'][] = ['label' => 'Board Entries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="board-entry-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
