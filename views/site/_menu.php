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
                        <?php /*?>
						<li class=""><a href="<?php echo Yii::$app->homeUrl;?>about">About us</a></li>
						<li class=""><a href="<?php echo Yii::$app->homeUrl;?>team">Team</a></li>
						
						<li class=""><a href="<?php echo Yii::$app->homeUrl;?>sitemap">Sitemap</a></li>
                        <?php /*?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Features <span class="caret"></span></a>
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
                        <li><a href="#">Foods</a></li>
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
                        <li>
                            <a href="<?php echo Yii::$app->homeUrl;?>search" class="bar-link-a bar-lghtWarning">
                                <i class="fa fa-cutlery"></i>
                                <span class="bar-mwdth">
                                    Search
                                </span>
                            </a>
                        </li>
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
    <div class="col-lg-6 hide">
        <a href="" class="logo-link">
            <img alt="cook board" class="logoIndex img-responsive" src="http://d2qcctj8epnr7y.cloudfront.net/images/2013/logo-CookBoard-2.png">
        </a>
    </div>
    <div class="col-lg-6 text-right hide">
        <div class="wrap-loginUser">
            <a href="" class="link-signIn font-bold font-raleway">
                <i class="fa fa-sign-in"></i>
                Sign in
            </a>
             or via
             <div class="btn-group">
                <a href="" class="btn btn-primary btn-sm">
                    <i class="fa fa-facebook"></i>
                    facebook
                </a>
                <a href="" class="btn btn-success btn-sm">
                    <i class="fa fa-google-plus"></i>
                    gmail
                </a>
             </div>
        </div>
    </div>
    
    
    
<!--</div>-->