<style>
    div#b-details{
        left: -156px;
        position: absolute;
        top: -103px;
    }
    div#b-details2{
        left: 182px;
        position: absolute;
        top: -104px;
    }
    .f-right h3,.c-left h3,div#b-details2,div#b-details{
        text-align: center;
    }
</style>
<div class="col-lg-8">
    <h1 class="bgTtle-header">
        Welcome to CookBoard!
    </h1>
    <p class="lead-Sub-desc">
        CookBoard is the #1 Local Food Marketplace where you can buy and sell food items from your local chefs, local cooks in your community.
    </p>
    <br>
    <p class="lead-Sub-desc">
        Make new friends. Taste new dishes. All fresh. All local.
    </p>
    <br>
	<?php
		 if(Yii::$app->user->isGuest){
	?>
    <h2>Join As A</h2>
    <br>
    <div class="row">
        <div class="col-md-4">
            <a href="<?=Yii::$app->urlManager->createUrl(['site/login']);?>" class="btn btn-large btn-block btn-warning choice show-details">
                <img src="http://d2qcctj8epnr7y.cloudfront.net/uploads/cook-l.png">&nbsp;
                Cook
            </a>
            <div id="b-details">
                <div class="c-right">
                    <img src="http://www.domaindirectory.com/images/icon/arrow-58-xxl.png" style="width:140px; margin-top:14px;">
                </div>
                <div class="c-left">
                    <h3>Join as a <span>Cook</span></h3>
                    <p>Share and sell your specialty food items to your community.</p>
                </div>
                <div style="clear:both"></div>
            </div>
        </div>
        <div class="col-md-1 text-center">
            <h4><span  class="line-center">OR</span></h4>
        </div>
        <div class="col-md-4">
            <a href="<?=Yii::$app->urlManager->createUrl(['site/login']);?>" class="btn btn-large btn-block btn-warning choice show-details2">
                <img src="http://d2qcctj8epnr7y.cloudfront.net/uploads/restaurant-3-l.png">&nbsp;
                Foodie
            </a>
            <div id="b-details2">
                <div class="f-left">
                    <img src="http://www.domaindirectory.com/images/icon/arrow-58-xxl2.png" style="width:140px; margin-top:14px;">
                </div>
                <div class="f-right">
                    <h3>Join as a <span>Foodie</span></h3>
                    <p>Taste specialty food items from your community's local home cooks and chefs.</p>
                </div>
                <div style="clear:both"></div>
            </div>
        </div>
    </div>
    <br>
	
	<?php
	}
	?>
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-54814a0070a53e3f" async="async"></script>
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <div class="addthis_sharing_toolbox"></div>
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
	<?php }?></div>