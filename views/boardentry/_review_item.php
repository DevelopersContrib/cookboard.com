<?php
	foreach($reviews as $item){
?>
<li>
	<div class="media">
		<div class="media-left pull-left">
			<?php
				$img = !empty($item->user->photo)?Yii::$app->homeUrl.'pix/'.$item->user->photo:'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png';
			?>
			<a target="_blank" class="pub-name" href="<?=\Yii::$app->urlManager->createUrl(['profile/index', 'slug' => $item->user->slug]);?>">
				<img width="64" height="64" class="media-object" src="<?=$img?>">
			</a>
		</div>
		<div class="media-body">
			<?php
				if($currentuser->id==$item->user_id){
			?>
			<a data-id="<?=$item->id?>" href="javascript:;" class="close remove-review" ><span aria-hidden="true">×</span></a>
			<?php }?>
			<a target="_blank" class="pub-name" href="<?=\Yii::$app->urlManager->createUrl(['profile/index', 'slug' => $item->user->slug]);?>">
			<h4 class="media-heading text-capitalize"><?=$item->user->username?></h4>
			</a>
			<p>
				<i class="fa fa-quote-left"></i>
				<?=stripslashes($item->message)?>
				<i class="fa fa-quote-right"></i>
			</p>
			<?php
				
				$ptime = strtotime($item->datetime_created);
				
				$time_ago = $ptime;
				$cur_time   = time();
				$time_elapsed   = $cur_time - $time_ago;
				$seconds    = $time_elapsed ;
				$minutes    = round($time_elapsed / 60 );
				$hours      = round($time_elapsed / 3600);
				$days       = round($time_elapsed / 86400 );
				$weeks      = round($time_elapsed / 604800);
				$months     = round($time_elapsed / 2600640 );
				$years      = round($time_elapsed / 31207680 );
				// Seconds
				if($seconds <= 60){
					$ptime = "just now";
				}
				//Minutes
				else if($minutes <=60){
					if($minutes==1){
						$ptime ="one minute ago";
					}else{
						$ptime ="$minutes minutes ago";
					}
				}
				//Hours
				else if($hours <=24){
					if($hours==1){
						$ptime ="an hour ago";
					}else{
						$ptime ="$hours hrs ago";
					}
				}
				//Days
				else if($days <= 7){
					if($days==1){
						$ptime ="yesterday";
					}else{
						$ptime ="$days days ago";
					}
				}
				//Weeks
				else if($weeks <= 4.3){
					if($weeks==1){
						$ptime ="a week ago";
					}else{
						$ptime ="$weeks weeks ago";
					}
				}
				//Months
				else if($months <=12){
					if($months==1){
						$ptime ="a month ago";
					}else{
						$ptime ="$months months ago";
					}
				}
				//Years
				else{
					if($years==1){
						$ptime ="one year ago";
					}else{
						$ptime ="$years years ago";
					}
				}
			
			?>
			<small><?=$ptime?></small>
		</div>
	</div>
</li>
<?php
	}
?>