<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BoardEntry */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Board Entries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="board-entry-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'datetime_created',
            'user_id',
            'description:ntext',
            'cuisine_id',
            'course_id',
            'diet_id',
            'city',
            'rating',
            'delivery_type_id',
            'price',
        ],
    ]) ?>

</div>
