<?php 
$this->registerCssFile(Yii::$app->homeUrl."css/cook-profile.css",['depends' => 'app\assets\AppAsset']);
$this->registerCssFile(Yii::$app->homeUrl."css/album.css",['depends' => 'app\assets\AppAsset']);

$this->title = $profile->username;
$this->params['breadcrumbs'] =[
    $this->title,
];
?>
<!-- profile-container -->
<div class="profile-container">			
  <div class="col-xs-12 col-md-8">
        <div class="profile-left">
                <div class="pro-fol">
                        <div class="btn-group">
                          <button type="button" class="btn btn-default">Likes&nbsp;<b>0</b></button>
                          <button type="button" class="btn btn-default">Followers&nbsp;<b>0</b></button>
                          <button type="button" class="btn btn-default">Following&nbsp;<b>0</b></button>
                        </div>
                </div>
                <div style="clear:both"></div>
                <?php if(!Yii::$app->user->isGuest){?>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                  <li class="active"><a href="#boards" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-dashboard"></span>&nbsp;Boards</a></li>
                  <li><a href="#recipes" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-list"></span>&nbsp;My Recipes</a></li>
                  <li><a href="#favorites" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-heart"></span>&nbsp;My Favorites</a></li>
                  <li><a href="#posts" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-pushpin"></span>&nbsp;My Posts</a></li>
                </ul>
                <?php }?>
                <!-- Tab panes -->
                <div class="tab-content tc-pad">
                  <div class="tab-pane active" id="boards">
                        <?//=$this->render('_index_boards')?>
                        <?php
                            foreach($cookboard as $item){
                                echo $this->render('_index_boards',['item'=>$item]);
                            }
                        ?>
                  </div>
                  <div class="tab-pane" id="recipes">
                        <?=$this->render('_index_my_recipes')?>
                  </div>
                  <div class="tab-pane" id="favorites">
                        <?=$this->render('_index_my_favorites')?>
                  </div>
                  <div class="tab-pane" id="posts">
                        <?=$this->render('_index_my_posts')?>
                        
                  </div>
                </div>
        </div>
  </div>
  <?=$this->render('_index_right',['profile'=>$profile]);?>
  <div style="clear:both"></div>
</div>
<!-- end profile-container -->
<?php $this->registerJsFile(Yii::$app->homeUrl.'js/vendor/imgCentering.min.js',['depends' => 'yii\web\AssetBundle'] ); ?>
<?php $this->registerJs($this->render('index_js.php')); ?>