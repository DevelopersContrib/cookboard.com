
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tester */


?>
<div class="tester-view">

    <h1>Import Photo</h1>

    <div class="widget-content" style="min-height: 251px;">	

						<? //echo $stream_id; ?>
						
						<div class="row-fluid" style="text-align: center;padding-top: 45px;">
							<h4>Select social network to import from</h4>
							<div class="row-fluid">
								<ul class="inline">
									<li>
										<a class="upload-social-network" href=""><img src="http://d2qcctj8epnr7y.cloudfront.net/sheina/photostream/insta-round.png" /></a>
										
									</li>
									<li>
										<a class="upload-social-network" href=""><img src="http://d2qcctj8epnr7y.cloudfront.net/sheina/photostream/facebook.png" /></a>
									</li>
									<li>
										<a class="upload-social-network" href="<?php echo Yii::$app->homeUrl;?>tester/pinterest"><img src="http://d2qcctj8epnr7y.cloudfront.net/sheina/photostream/pinterest.png" /></a>
									</li>
								
								</ul>
							</div>
						</div>
				</div>

  

</div>