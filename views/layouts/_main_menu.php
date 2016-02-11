<!--<div class="row">-->
    <div class="col-lg-12">
        <nav class="navbar navbar-default bar-custm" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?php echo Yii::$app->homeUrl;?>">
                            <img alt="cook board" class="logoIndex img-responsive" src="http://d2qcctj8epnr7y.cloudfront.net/images/2013/logo-CookBoard-2.png">
                        </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav bar-custm-nav">
						<?php
						if(!Yii::$app->user->isGuest){
						?>
                        <li><a href="<?php echo Yii::$app->homeUrl;?>dashboard">Dashboard</a></li>
                        <li><a href="<?php echo Yii::$app->homeUrl;?>cookboard">Create Cookboard</a></li>
						<?php
						}
						?>
						<?php /*?>
						<li class=""><a href="<?php echo Yii::$app->homeUrl;?>about">About us</a></li>
						<li class=""><a href="<?php echo Yii::$app->homeUrl;?>team">Team</a></li>
						<li class=""><a href="<?php echo Yii::$app->homeUrl;?>sitemap">Sitemap</a></li>
                        
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Components <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                                <li class="divider"></li>
                                <li><a href="#">One more separated link</a></li>
                            </ul>
                        </li>
                        <?php */?>

                    </ul>
                    <ul class="nav navbar-nav navbar-right bar-custm-nav">
                        <?php
                        if (Yii::$app->getSession()->has('cart') && count(Yii::$app->getSession()->get('cart'))>0) {
                        ?>
                        <li>
                            <a href="<?php echo Yii::$app->homeUrl;?>checkout" class="bar-link-a bar-lghtWarning">
                                <span class="glyphicon glyphicon-shopping-cart"></span>
                                <span class="bar-mwdth">
                                    Cart
                                </span>
                            </a>
                        </li>
                        <?php
                        }
                        ?>
						<li style="display:none">
							<a href="#" class="dropdown-toggle bar-link-a bar-lghtWarning">
								<i class="fa fa-envelope cookpot"></i>
								<span class="count">3</span>
							</a>
						</li>
                        <li>
                            <a href="<?php echo Yii::$app->homeUrl;?>search" class="bar-link-a bar-lghtWarning">
                                <i class="fa fa-cutlery"></i>
                                <span class="bar-mwdth">
                                    Search
                                </span>
                            </a>
                        </li>
                        <?php
                        if(!Yii::$app->user->isGuest){
                        ?>
                        <li class="dropdown">
                            <a href="#" class="bar-link-a bar-lghtWarning dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-cogs"></i>
                                <span class="bar-mwdth">
                                    Account Settings
                                </span>
                            </a>
                            <ul class="dropdown-menu menu-right" role="menu">
                                <li><a id='mnu-edit-profile' href="javascript:;">Edit Profile</a></li>
                                <li class="divider"></li>
                                <?php
                                    $identity = Yii::$app->getUser()->getIdentity();
                                    if($identity->type!==\app\models\UserModel::PREMIUM){
                                ?>
                                <li><a id='mnu-edit-profile' href="<?=Yii::$app->urlManager->createUrl(['profile/upgrade'])?>">Upgrade to Premium Account</a></li>
                                <?php
                                    }
                                ?>
<!--                                <li><a id='mnu-edit-profile' href="<?=Yii::$app->urlManager->createUrl(['profile/photos'])?>">Photos</a></li>-->                                
                            </ul>
                        </li>
                        <?php
                        }
                        ?>
                        <li>
                            <?php
                            if(Yii::$app->user->isGuest){
                            ?>
                            <a href="<?php echo Yii::$app->homeUrl;?>login" class="bar-link-a bar-warning">
                                <i class="fa fa-sign-in"></i>
                                Sign in
                            </a>
                            <?php
                            }else{
                            ?>
                            <a href="<?php echo Yii::$app->homeUrl;?>logout" class="bar-link-a bar-warning">
                                <i class="fa fa-sign-in"></i>
                                <?php
                                        $identity = Yii::$app->getUser()->getIdentity();
                                        echo 'Hi, '.$identity->username;
                                ?>
                                <br> Logout
                            </a>
                            <?php
                            }
                            ?>
                        </li>
                        
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </div>
<!--</div>-->
<style>
.count {
position: absolute;
top: 24%;
right: 15%;
font-size: 16px;
font-weight: normal;
background: none repeat scroll 0% 0% rgba(41, 200, 41, 0.75);
color: #FFF;
line-height: 1em;
padding: 2px 6px;
border-radius: 10px;
border: 1px solid #F77F08;
}
.fa-envelope {
margin-top:15px;
}
</style>
