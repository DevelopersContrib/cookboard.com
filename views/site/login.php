<?php
    $this->title = 'Login';
    $this->registerCss('.eauth{display:none;}');
?>
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-xs-offset-2 wrapLoginCenter">
            <div class="clearfix"></div>
            <a href="javascript:;" class="btn btn-default pull-right">Log in</a>
            <div class="text-center">
                <img class="logoIndex img-responsive" src="http://d2qcctj8epnr7y.cloudfront.net/images/2013/logo-CookBoard-2.png">
                <?php
					//if (Yii::$app->getSession()->hasFlash('error')) {
						//echo '<div class="alert alert-danger">'.Yii::$app->getSession()->getFlash('error').'</div>';
					//}
				?>
				<h2 class="marTop0 text-white">
                        He used Cookboard to start his collection 
                </h2>
                <p class="text-white">
                        Join Cookboard to find (and save!) all the things that inspire you. 
                </p>
                <div class="wrapHalf-containerCenter">
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
                <div class="wrapHalf-containerCenter">
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
        </div>
    </div>
</div>
<?php
$this->registerJs(''
    . '$("#login-fb").on("click",function(){$(".eauth-service-id-facebook a").trigger("click");});'
    . '$("#login-twitter").on("click",function(){$(".eauth-service-id-twitter a").trigger("click");});');
?>