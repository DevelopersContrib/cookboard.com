<div class="row">
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
                        <li><a href="<?php echo Yii::$app->homeUrl;?>cookboard">Create Cookboard</a></li>
                        <?php /*?>
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
                                    Search for foods
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
                                <li><a id='mnu-edit-profile' href="javascript:;">Edit Profile</a>
                                </li>
                                <li class="divider"></li>
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
</div>
