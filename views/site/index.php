<?php
    $this->title = 'Cookboard.com';
?>
<div class="wrap-home-container font-raleways">
    <div class="container">
        <?php
          if(Yii::$app->user->isGuest){
            echo $this->render('_menu'); 
          }else{
              echo $this->render('//layouts/_main_menu'); 
          }
        ?>
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
<?= $this->render('_board',['cookboard'=>$cookboard]) ?>
<?php $this->registerJs($this->render('index_js.php')); ?>
