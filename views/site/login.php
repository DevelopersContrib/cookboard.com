<?php
    $this->title = 'Login';
    $this->registerCss('.eauth{display:none;}');
?>
<div class="container">
    <div class="row">
		<div class="col-xs-12">
        <div class="wrapLoginCenter">
            <div class="clearfix"></div>
            <a href="javascript:;" class="btn btn-warning pull-right" style="margin-right:10px;display:none;">Log in</a>
            <div class="col-xs-12 text-center">
                <img class="logoIndex img-responsive" src="http://d2qcctj8epnr7y.cloudfront.net/images/2013/logo-CookBoard-2.png">
                <?php
					//if (Yii::$app->getSession()->hasFlash('error')) {
						//echo '<div class="alert alert-danger">'.Yii::$app->getSession()->getFlash('error').'</div>';
					//}
				?>
				<h2 class="marTop0 text-white tdesc">
                    Make new friends. Taste new dishes. All fresh. All local.  
                </h2>
                <p class="text-white sdesc">
                    Join our Food Loving Community as Cook or a Foodie 
                </p>
                <div class="col-md-6 col-md-offset-3 wrapHalf-containerCenter">
                    <div class="form-group">
                        <a id="login-fb" href="javascript:;" class="btn btn-primary btn-block"> 
                                <i class="fa fa-facebook"></i>
                                Continue with Facebook 
                        </a>
                    </div>
                    <div class="form-group">
                        <a id="login-twitter" href="javascript:;" class="btn btn-info btn-block">
                                <i class="fa fa-twitter"></i>
                                Continue with Twitter
                        </a>
                    </div>
                    <?php echo \nodge\eauth\Widget::widget(array('action' => 'site/login')); ?>
                </div>
                <?php /*?>
                <div class="wrapSeparatorPosition">
                    <div class="wrapSeparator">
                        <p>
                                or
                        </p>
                    </div>
                </div>
                <?php */?>
                <div class="clearfix"></div>
                <div class="col-md-6 col-md-offset-3 wrapHalf-containerCenter">
                    <?php /*?>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Create a password">
                    </div>
                    <div class="form-group">
                        <a href="" class="btn btn-danger btn-block">
                                Sign up
                        </a>
                    </div>
                    <?php */?>
                    <div class="form-group">
                        <small class="text-white">
                                Creating an account means you’re okay with Cookboard's
                                <a href="" class="text-bold aLink-terms">Terms of Services</a> and <a href="" class="text-bold aLink-terms">Privacy and Policy</a>
                        </small>
                    </div>
                </div>
            </div>
			<div class="clearfix"></div>
        </div>
		</div>
    </div>
</div>
<?php
$this->registerJs(''
    . '$("#login-fb").on("click",function(){$(".eauth-service-id-facebook a").trigger("click");});'
    . '$("#login-twitter").on("click",function(){$(".eauth-service-id-twitter a").trigger("click");});');
?>