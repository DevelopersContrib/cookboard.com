
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tester */
 $this->registerCss('.eauth{display:none;}');

$this->title = "Import Photo";
?>
<div class="tester-view">

    <h1>Import Photo</h1>

    <div class="widget-content" style="min-height: 251px;">	

						
						
						<div class="row-fluid" style="text-align: center;padding-top: 45px;">
							<h4>Select social network to import from</h4>
							<div class="row-fluid">
								<ul class="inline">
									<li>
										<a class="upload-social-network" href="<?echo $insta_link;?>"><img src="http://d2qcctj8epnr7y.cloudfront.net/sheina/photostream/insta-round.png" /></a>
										
									</li>
									<li>
										<a id="login-fb" class="upload-social-network" href="javascript:;"><img src="http://d2qcctj8epnr7y.cloudfront.net/sheina/photostream/facebook.png" /></a>
										 <!--  <div class="form-group">
											<a id="login-fb" href="javascript:;" class="btn btn-primary btn-block"> 
													<i class="fa fa-facebook"></i>
													Continue with Facebook 
											</a>
										</div>-->
									</li>
									<li>
										<a class="upload-social-network" href="<?php echo Yii::$app->homeUrl;?>import/pinterest"><img src="http://d2qcctj8epnr7y.cloudfront.net/sheina/photostream/pinterest.png" /></a>
									</li>
								
								</ul>
								 <?php echo \nodge\eauth\Widget::widget(array('action' => 'import/facebook')); ?>
							</div>
						</div>
				</div>

  

</div>
<?php
$this->registerJs(''
    . '$("#login-fb").on("click",function(){$(".eauth-service-id-facebook a").trigger("click");});');
?>