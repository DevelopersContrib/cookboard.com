<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BoardEntryModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Board Entries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="board-entry-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Board Entry', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'datetime_created',
            'user_id',
            'description:ntext',
            'cuisine_id',
            // 'course_id',
            // 'diet_id',
            // 'city',
            // 'rating',
            // 'delivery_type_id',
            // 'price',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
