<?php
	$this->registerCssFile(Yii::$app->homeUrl."css/album.css",['depends' => 'app\assets\AppAsset']);
    $this->registerCssFile(Yii::$app->homeUrl."css/newhome.css",['depends' => 'app\assets\AppAsset']);
    $this->title = 'Cookboard.com';
?>
<div class="htop">
    <div class="container">
        <?php
            if(Yii::$app->user->isGuest){
                echo $this->render('_menu'); 
            }else{
                echo $this->render('//layouts/_main_menu'); 
            }
        ?>
    </div>
</div>
<div class="wrap-home-container font-raleways">	
    <div class="blckOpcty"></div>
    <div class="container">       
        <?php
            // $identity = Yii::$app->getUser()->getIdentity();
            // echo '<pre>';
            // print_r($identity);
            // echo '</pre>';
        ?>
        <div class="row">
            <?= $this->render('_welcome') ?>
            <?= $this->render('_search') ?>
        </div>
    </div>
</div>

<?= $this->render('_board',['cookboard'=>$cookboard/*,'boards'=>$boards*/]) ?>
<?php $this->registerJs($this->render('index_js.php')); ?>

<style>
.htop {
background:#fff;
margin-bottom:20px;
box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
}
.navbar {
margin-bottom:0px;
}
</style>