<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Models';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-model-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User Model', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'password',
            'email:email',
            'type',
            // 'datetime_created',
            // 'authKey',
            // 'auth_key',
            // 'notes',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
