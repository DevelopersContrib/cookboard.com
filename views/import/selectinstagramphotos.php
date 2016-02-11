<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tester */

$this->title = "Instagram Photos";
?>
<div class="tester-view">

    <h1>Import Photo</h1>

    <div class="widget-content" style="min-height: 251px;">	


			<? date_default_timezone_set('UTC'); $i=0; $x= date("l, F d, Y " ,time()); ?>
						<?php if(is_object($user_feed)) { ?>

							<?php foreach($user_feed->data as $feed_item) { ?>
							
								<?php if($feed_item->type == 'image') { ?>
								<div class="grid" id="<?=$i?>">
									<!--<div class="photohover" id="hover<?//=$i?>"><img src="<?//=base_url()?>img/plus.png"><b>&nbsp; Add to PhotoStream</b></div>-->
									<div class="imgholder">
										<label class="ps-label" for="insta<?=$i?>">
										<img id="img<?=$i?>" src="<?=$feed_item->images->standard_resolution->url?>" alt="<? echo "insta ".$x;?>" />
										</label>
									</div>
									<div class="meta"></div>
									<input id="insta<?=$i?>" class="check" name="checkupload" id="checkupload" type="checkbox" value="<?=$feed_item->images->standard_resolution->url?>" />
								</div>
								<? $i++; ?>
							<? } ?>
						<? } ?>
					<?} ?>
						
	</div>

  

</div>