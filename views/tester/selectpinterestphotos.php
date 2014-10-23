<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tester */


?>
<div class="tester-view">

    <h1>Import Photo</h1>

    <div class="widget-content" style="min-height: 251px;">	


			<? if($res){?>
				<?foreach($res as $pin){?>
					<div class="grid" id="<?=$i?>">
						<!--<div class="photohover" id="hover<?//=$i?>"><img src="<?//=base_url()?>img/plus.png"><b>&nbsp; Add to PhotoStream</b></div>-->
						<div class="imgholder">
							<label class="ps-label" for="pin<?=$i?>">
							<img id="img<?=$i?>" src="<?=$pin['url']?>" alt="<?=(str_replace(' ','',$pin['title'])!='')?$pin['title']:'Pinterest '.$i.' '.date('Ymd His')?>" />
							</label>
						</div>
						<div class="meta"><?=(str_replace(' ','',$pin['title'])!='')?$pin['title']:'Pinterest '.$i.' '.date('Ymd His')?></div>
						<input id="pin<?=$i?>" class="check" name="checkupload" id="checkupload" type="checkbox" value="<?=$pin['url']?>" />
					</div>
					<? $i++; ?>
				<? } ?>
			<? } ?>
						
	</div>

  

</div>