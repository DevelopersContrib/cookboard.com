<div class="col-lg-8">
    <h1 class="bgTtle-header">
        Welcome to CookBoard!
    </h1>
    <p class="lead-Sub-desc">
        CookBoard is the ultimate cooking social community, where recipes come to life. Wanna know what you will gain by joining us? Lorem ipsum dolor sit amet, this is some teaser text.
    </p>
    <br>
    <p class="lead-Sub-desc">
        You will win awesome prizes, make new friends and share delicious recipes. 
    </p>
    <br>
    <br>
    <br>
    <p>
        <a href="" class="btn btn-warning btn-lg">
            Join our community 
            <i class="fa fa-angle-right"></i>
        </a>
    </p>
    <br>
    <br>
    <br>
	<?php
		if(Yii::$app->user->isGuest){
	?>
    <p class="lead-Sub-desc">
        Already a member? Click 
        <a href="<?php echo Yii::$app->homeUrl;?>login" class="login-link">here</a> to login.
    </p>
	<?php }?>
</div>