<?php
    $this->title = 'Sitemap';
?>
<style>
.group-links{
	background-color: #fff;
    margin-bottom: 20px;
    padding: 15px;
}
</style>
<?php
    echo '<div class="group-links" >';
    echo '<h2>Main</h2>';
    echo '<a class="label label-info text-capitalize" href="'.Yii::$app->homeUrl.'">Home</a><br>';
    echo '<a class="label label-info text-capitalize" href="'.Yii::$app->urlManager->createUrl(['site/about']).'">About Us</a><br>';
    echo '<a class="label label-info text-capitalize" href="'.Yii::$app->urlManager->createUrl(['site/team']).'">Team</a><br>';
    echo '<a class="label label-info text-capitalize" href="'.Yii::$app->urlManager->createUrl(['search/index']).'">Search</a><br>';
    echo '<a class="label label-info text-capitalize" href="'.Yii::$app->urlManager->createUrl(['site/login']).'">Login</a><br>';
    echo '<a class="label label-info text-capitalize" href="'.Yii::$app->urlManager->createUrl(['site/privacy']).'">Privacy</a><br>';
    echo '<a class="label label-info text-capitalize" href="'.Yii::$app->urlManager->createUrl(['site/toc']).'">Terms and Condition</a><br>';
    echo '</div>';
    
    echo '<div class="group-links">';
    echo '<h2>Profile</h2>';
    foreach($users as $user){
        echo "<a class='label label-warning text-capitalize' href='".Yii::$app->homeUrl.$user->slug."'>".$user->username.'</a><br>';
    }
    echo '</div>';
    
    echo '<div class="group-links">';
    echo '<h2>Cookboard</h2>';
    
    foreach($cookboards as $cookboard){
        echo "<a class='label label-info text-capitalize' href='".Yii::$app->urlManager->createUrl(['cookboard/details', 'slug' => $cookboard->slug])."'>".$cookboard->name.'</a><br>';
    }
    echo '</div>';
    
    echo '<div class="group-links">';
    echo '<h2>Board Entry</h2>';
    
    foreach($boards as $board){
      
        echo "<a class='label label-warning text-capitalize' href='".Yii::$app->urlManager->createUrl(['boardentry/details', 'cookboard'=> $board->cookboard['slug'], 'slug' => $board->slug])."'>".$board->name.'</a><br>';
    }
    echo '</div>';
?>