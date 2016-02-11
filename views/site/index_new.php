<?php
    $this->title = 'Cookboard.com';
    $this->registerCssFile(Yii::$app->homeUrl."css/newhome.css",['depends' => 'app\assets\AppAsset']);
?>

<div class="htop">
	<div class="container">
		<div class="row">
			<?php
          if(Yii::$app->user->isGuest){
            
            echo $this->render('_menu'); 
          }else{
              echo $this->render('//layouts/_main_menu'); 
          }
        ?>
		</div>
	</div>
</div>

<div class="wrap-home-container font-raleways">
    <div class="container">
        <div class="row">
        
            <?=$this->render('_new_home', ['cities'=>$cities]); ?>
        </div>
    </div>
</div>
<?//= $this->render('_board',['cookboard'=>$cookboard]) ?>
<?php //$this->registerJs($this->render('index_js.php')); ?>
