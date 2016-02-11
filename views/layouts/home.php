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
	
	<!-- Piwik -->
	<script type="text/javascript">
	  var _paq = _paq || [];
	  _paq.push(['trackPageView']);
	  _paq.push(['enableLinkTracking']);
	  (function() {
		var u="//www.stats.numberchallenge.com/";
		_paq.push(['setTrackerUrl', u+'piwik.php']);
		_paq.push(['setSiteId', 1707]);
		var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
		g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
	  })();
	</script>
	<noscript><p><img src="//www.stats.numberchallenge.com/piwik.php?idsite=1" style="border:0;" alt="" /></p></noscript>
	<!-- End Piwik Code -->
	
</head>
<body><?php $this->beginBody() ?>
    <?= $content ?>
    <?php
    if(!Yii::$app->user->isGuest){
        echo $this->render('//site/_profile_modal');
    }
	echo $this->render('footer');
    ?>
    
    <?php $this->endBody() ?>
    
    <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-backstretch/2.0.4/jquery.backstretch.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/masonry/3.1.5/masonry.pkgd.min.js"></script>
    <script type="text/javascript" src="<?=Yii::$app->homeUrl.'js/vendor/imgCentering.min.js'?>"></script>
    
    <!-- 
        http://rdbuploads.s3.amazonaws.com/backgrounds/photodune-311286--beef-f.jpg
        http://rdbuploads.s3.amazonaws.com/uploads/cookboard/cookboard-photoshoot.jpg 
    -->
    <script type="text/javascript">
        jQuery(document).ready(function(){
            <?php if(!Yii::$app->user->isGuest){?>
            jQuery('.wrap-home-container').backstretch("http://rdbuploads.s3.amazonaws.com/uploads/cookboard/cookboard-photoshoot.jpg ");
            <?php }?>
            jQuery('#wrapper-container').masonry({
                itemSelector : '.item'
            });
            jQuery(".wrap-item-img2 .img-cntre").imgCentering();
        });
    </script>
</body>
</html>
<?php $this->endPage() ?>