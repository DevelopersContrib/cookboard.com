<?php
use yii\helpers\Html;
use app\assets\HomeAsset;
use yii\helpers\VarDumper;

/* @var $this \yii\web\View */
/* @var $content string */

HomeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-41643668-16', 'cookboard.com');
        ga('send', 'pageview');

    </script>
</head>
<body><?php $this->beginBody() ?>
    <?= $content ?>
    <?php
    if(!Yii::$app->user->isGuest){
        echo $this->render('//site/_profile_modal');
    }
    ?>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer-content">

                    </div>
                    <div class="footer-credit">
                            All Rights Reserved 2014. Cookboard.com
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php $this->endBody() ?>
    
    <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/masonry/3.1.5/masonry.pkgd.min.js"></script>
    <script type="text/javascript" src="<?=Yii::$app->homeUrl.'js/vendor/imgCentering.min.js'?>"></script>

    <script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery('.wrap-home-container').backstretch("http://rdbuploads.s3.amazonaws.com/backgrounds/photodune-311286--beef-f.jpg");
            jQuery('#wrapper-container').masonry({
                itemSelector : '.item'
            });
            jQuery(".wrap-item-img2 .img-cntre").imgCentering();
        });
    </script>
</body>
</html>
<?php $this->endPage() ?>