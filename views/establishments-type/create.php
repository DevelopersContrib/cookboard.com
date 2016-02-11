<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EstablishmentsType */

$this->title = 'Create Establishments Type';
$this->params['breadcrumbs'][] = ['label' => 'Establishments Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="establishments-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
