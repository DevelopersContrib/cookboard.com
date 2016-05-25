<?php
	if(empty($currentuser) && empty($model->review)){
	}else{
		
?>

<div class="row" >
	<div class="col-md-12">
		<div class="wrap-box-review-container font-openSans">
			<div class="wrap-box-review-header">
				<div class="wrap-box-title">
					<i class="fa fa-comments-o"></i>
					Review Comments
				</div>
			</div>
			<div class="wrap-box-review-body">
				<ul class="list-unstyled ul-review-comment">
					<?php
						echo $this->render('_review_item',['reviews'=>$model->review,'currentuser'=>$currentuser]);
					if(!empty($currentuser)){
					?>
					<li id="li-review">
						<div class="media">
							<div class="media-left">
								<?php
									$img = !empty($currentuser->photo)?Yii::$app->homeUrl.'pix/'.$currentuser->photo:'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png';
								?>
								<img width="64" height="64" class="media-object" src="<?=$img?>">
							</div>
							<div class="media-body">
								<div class="form-group">
									<textarea id="txt-review" rows="5" class="form-control" placeholder="Add comment"></textarea>
								</div>
								<div class="form-group">
									<a data-id="<?=$model->id?>" id="btn-review" href="javascript:;" class="btn btn-lg btn-warning">
										<i class="fa fa-comments-o"></i>
										Add Comment
									</a>
								</div>
							</div>
						</div>
					</li>
					<?php
					}
					?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php
	} 
?>