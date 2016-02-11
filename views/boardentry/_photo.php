<div class="col-md-12 col-sm-6 col-lg-3 col-xs-12 paddItem item photo-entry">
    <div class="wrap-item">
        <div class="wrap-item-img">
            <?php
                $img = $photo->external===1?$photo->photo:Yii::$app->homeUrl.$photo->photo;
            ?>
            <a class="photo" href="<?=$img?>" data-imagelightbox="g">
                <img class="img-responsive" alt="name of image" src="<?=$img?>" />
            </a>
        </div>
        <ul class="list-unstyled ul-wrap-item-info">
            <li>
                <span class="text-capilize">
                    <span class="hghlght-text font-raleways font-500">
                        <?=$photo->title?>
                    </span>
                </span>
            </li>
            <li>
                <span class="text-capitalize">
                   <?=$photo->description?>
                </span>
            </li>

        </ul>
    </div>
</div>