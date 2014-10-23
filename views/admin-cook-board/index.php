<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CookBoardModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cook Boards';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cook-board-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cook Board', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'datetime_created',
            'user_id',
            'name',
            'description:ntext',
            // 'featured',
            // 'image',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
