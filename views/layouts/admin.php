<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
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
<style>
    table {
        background-color: #fff;
    }
</style>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Cookboard.com',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            if(Yii::$app->user->isGuest){
                $items = [
                    ['label' => 'Home', 'url' => ['/admin/index']],
                    ['label' => 'Login', 'url' => ['/admin/login']],
                ];
            }else{
                $items = [
                    ['label' => 'Home', 'url' => ['/admin/index']],
                    ['label' => 'Board Entry', 'url' => ['/admin-board-entry']],
                    ['label' => 'Cook Board', 'url' => ['/admin-cook-board']],
                    ['label' => 'Cuisine', 'url' => ['/admin-cuisine']],
                    ['label' => 'Course', 'url' => ['/admin-course']],
                    ['label' => 'Delivery Type', 'url' => ['/admin-delivery-type']],
                    ['label' => 'Diet', 'url' => ['/admin-diet']],
                    ['label' => 'Messages', 'url' => ['/admin-messages']],
                    ['label' => 'Users', 'url' => ['/user']],
                    ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                        'url' => ['/admin/logout'],
                        'linkOptions' => ['data-method' => 'post']]
                ];
            }
            echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items' => $items
                ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?php
                //var_dump(Yii::$app->controller->page);
            ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Cookboard.com <?= date('Y') ?></p>
            <p class="pull-right">Powered by <a rel="external" href="http://contrib.com/">Contrib.com</a></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
