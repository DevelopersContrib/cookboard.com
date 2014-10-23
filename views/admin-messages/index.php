<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MessagesModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Messages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="messages-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Messages', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'from_user_id',
            'to_user_id',
            'to_all_user',
            'subject',
            // 'content:ntext',
            // 'status',
            // 'datetime_created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
