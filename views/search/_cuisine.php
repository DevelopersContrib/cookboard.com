<div class="col-lg-6">
    <h3>Cuisine?</h3>
    <style type="text/css">
        .wrap-hideShowLess{
            height: 125px;
            overflow: hidden;
        }
    </style>
    <div class="wrap-hideShowLess-container">
        <div class="wrap-hideShowLess">
            <ul class="list-inline">
                <?php
                    foreach($cuisine as $item){
                ?>
                <li>
                    <h4 class="font-raleways font-300">
                            <a href="javascript:;" id="<?=$item->id?>" data-title="<?=$item->name?>" class="label label-warning cuisine">
                                <?=$item->name;?>
                            </a>
                    </h4>
                </li>
                <?php
                    }
                ?>        
            </ul>
        </div>
        <a href="javascript:;" class="whsl-btn-1">
            Show more...
        </a>
        <a href="javascript:;" class="whsl-btn-2 hide">
            Less...
        </a>
    </div>
</div>