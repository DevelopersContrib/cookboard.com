<div class="wrap-home-container-2">
    <div class="container">
        <div id="wrapper-container"  class="row wrapper-container">
            <?php 
                foreach($cookboard as $board){
                    foreach($board->boardEntry as $item){
                        $photos = $item->boardEntryPhotoList;
                        $img = 'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/colored-icon.png';
                        if(count($photos)>0){
                            $img = Yii::$app->homeUrl.reset($photos);
                        }
            ?>
                <div class="col-xs-12 col-sm-6 col-lg-3 paddItem item">
                    <div class="wrap-item">
                        <div class="wrap-item-img">
                            <a href="<?=Yii::$app->urlManager->createUrl(['boardentry/details', 'id' => $item->id]);?>">
                            <img class="img-responsive" alt="<?=$item->name;?>" src="<?=$img?>">
                            </a>
                        </div>
                        <ul class="list-unstyled ul-wrap-item-info">
                            <li>
                                <i class="fa fa-chain"></i> 
                                <span class="text-capitalize">
                                    <?=$item->name?>
                                </span>
                            </li>
                            <li>
                                <span class="text-capilize">
                                    <i class="fa fa-rub"></i> 
                                    <span class="hghlght-text font-raleways font-500">
                                        <?=$item->priceType->name.' '.number_format($item->price,2);?>
                                    </span>
                                </span>
                            </li>
                            <li>
                                <span class="text-capitalize">
                                    <i class="fa fa-map-marker"></i> 
                                    <?=$item->city?>
                                </span>
                            </li>
                            <li>

                                    <a class="pull-left" href="<?=\Yii::$app->urlManager->createUrl(['profile/index', 'slug' => $item->user->slug]);?>">
                                    <?php
                                        $user_photo = empty($item->user->photo)?'http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png':Yii::$app->homeUrl.'pix/'.$item->user->photo;
                                    ?>
                                    <img class="img-responsive img-circle wrap-item-img-user" src="<?=$user_photo?>">
                                </a>
                                <div class="wrap-item-user-info">
                                    <span class="text-lightBlck">
                                        Uploaded by
                                    </span>
                                    <span class="text-capitalize wrap-item-user-name">
                                        <a href="<?=\Yii::$app->urlManager->createUrl(['profile/index', 'slug' => $item->user->slug]);?>"><?=$item->user->username?></a>
                                    </span>
                                </div>
                                <div class="clearfix"></div>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php
                        break;
                    }
                }
            ?>
        </div>
    </div>
</div>