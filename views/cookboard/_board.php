<div id="board-<?php echo $item->id;?>" data-title="<?=$item->name?>" class="col-xs-12 col-sm-6 col-lg-3 paddItem wcca board">
    <div class="wrap-cookboard-container-album">
        <div class="wrap-block wcca-alink" title="<?=$item->name?>">
            <?php
                $img = '';
                foreach($item->items as $item_){
                    if(!empty($item_->board_entry_id)){
                        $entry = $item_->boardEntry;
                    }else if(!empty($item_->pin_board_entry_id)){
                        $entry = $item_->pinBoardEntry;
                    }
                    
                    $photos = $entry->boardEntryPhoto;
                    if(count($photos)>0){
                        $photo = $photos[0];
                        $img = $photo->external?$photo->photo:Yii::$app->homeUrl.$photo->photo;
                        $img = '<img src="'.$img.'" alt="'.$entry->name.'" class="img-responsive">';
                        break;
                    }
                }
                /*
                $entries = $item->boardEntryList;                
                
                if(count($entries)>0){
                    foreach($item->boardEntry as $entry){
                        $photos = $entry->boardEntryPhoto;
                        if(count($photos)>0){
                            //$img = Yii::$app->homeUrl.reset($photos);
                            $photo = $photos[0];
                            $img = $photo->external?$photo->photo:Yii::$app->homeUrl.$photo->photo;
                            $img = '<img src="'.$img.'" alt="'.$entry->name.'" class="img-responsive">';
                            break;
                        }
                    }
                }
                if(empty($img)){//get photo from pinned entry
                    $pins = $item->cookBoardPin;                
                    if(count($pins)>0){
                        foreach($pins as $pin){
                            //$photos = $pin->boardEntry->boardEntryPhotoList;
                            $photos = $pin->boardEntry->boardEntryPhoto;
                            if(count($photos)>0){
                                //$img = Yii::$app->homeUrl.reset($photos);
                                $photo = $photos[0];
                                $img = $photo->external?$photo->photo:Yii::$app->homeUrl.$photo->photo;
                                $img = '<img src="'.$img.'" alt="'.$pin->boardEntry->name.'" class="img-responsive">';
                                break;
                            }
                        }
                    }
                }
                */
                
                $img = empty($img)?$img = '<img src="http://d2qcctj8epnr7y.cloudfront.net/images/jayson/cookboard/grayscaled-icon.png" alt="no image upload" class="img-responsive no-img-upload">':$img;
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
                        <a href="<?=Yii::$app->urlManager->createUrl(['cookboard/details', 'slug' => $item->slug]);?>" class="wcca-btn-actions wcca-btn-actions1">
                            <i class="fa fa-search"></i>
                        </a>
                    </li>
                    <li>
                        <a id="<?=$item->id?>" href="javascript:;" class="wcca-btn-actions wcca-btn-actions2 edit-cookboard">
                            <i class="fa fa-edit"></i>
                        </a>
                    </li>
                    <li>
                        <a id="<?=$item->id?>" href="javascript:;" class="wcca-btn-actions wcca-btn-actions3 delete-cookboard">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </li>
                </ul>
                <span class="font-raleways font-500 wcca-action-word">&nbsp;</span>
        </div>
    </div>
</div>