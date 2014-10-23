<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tester */

$this->title = 'Create Tester';
$this->params['breadcrumbs'][] = ['label' => 'Testers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tester-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
