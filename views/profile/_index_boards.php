<?php /*?>
<div class="col-md-4" >
    <div class="panel panel-default">
      <div class="panel-heading">Sample Board #1</div>
      <div class="panel-body">
            <img class="img-responsive" src="http://media-cache-ec0.pinimg.com/236x/4c/78/3c/4c783c102e3fbb294e163ba50f9e969a.jpg">
      </div>						  
      <div class="panel-body bcontent">
            Stack of Grilled Cheese” sandwich at 47 Scott, as seen on Esquire magazine's Food For Men blog
      </div>
      <div class="panel-body bcontent">
            <a class="pull-left">
                <img class="img-responsive img-circle wrap-item-img-user" src="http://media-cache-ec0.pinimg.com/avatars/abcipriano_1378357861_140.jpg">
            </a>
            <div class="wrap-item-user-info">
                <span class="text-lightBlck">
                    Uploaded by
                </span>
                <span class="text-capitalize wrap-item-user-name">
                    Thomas Morato
                </span>
            </div>
      </div>
    </div>
</div>
<div style="clear:both"></div>
<?php */?>

<div id="board-<?php echo $item->id;?>" data-title="<?=$item->name?>" class="col-xs-12 col-sm-6 col-lg-3 paddItem wcca board">
    <div class="wrap-cookboard-container-album">
        <div class="wrap-block wcca-alink" title="<?=$item->name?>">
            <?php
                $entries = $item->boardEntryList;
                $img = '<img src="http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png" alt="no image upload" class="img-responsive no-img-upload">';

                if(count($entries)>0){
                    foreach($item->boardEntry as $entry){
                        $photos = $entry->boardEntryPhotoList;
                        if(count($photos)>0){
                            $img = Yii::$app->homeUrl.reset($photos);
                            $img = '<img src="'.$img.'" alt="no image upload" class="img-responsive">';
                            break;
                        }
                    }
                }
            ?>
            <div class="wrap-block wcca-img-featured">
                <?=$img;?>
            </div>
            <div class="wcca-header wrap-block">
                <span class="ellipsis wrap-block wcca-title text-capitalize">
                    <?=$item->name;?>
                </span>
            </div>
            <div class="wrap-block wcca-pins">
                <i class="fa fa-picture-o"></i> (<?=($item->board_count)?>) entries
            </div>
        </div>
        <div class="wrap-figCaption" title="<?=$item->description?>">
                <img class="img-responsive" src="http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/colored-icon.png">
                <ul class="list-inline ul-wcca-btn-actions">
                    <li>
                        <a href="<?=Yii::$app->urlManager->createUrl(['cookboard/details', 'id' => $item->id]);?>" class="wcca-btn-actions wcca-btn-actions1">
                            <i class="fa fa-search"></i>
                        </a>
                    </li>
                </ul>
                <span class="font-raleways font-500 wcca-action-word">&nbsp;</span>
        </div>
    </div>
</div>