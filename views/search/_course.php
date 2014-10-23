<div class="col-lg-6">
    <h3>Course?</h3>
    <ul class="list-inline">
        <?php
            foreach($course as $item){
        ?>
        <li>
            <h4 class="font-raleways font-300">
                <a href="javascript:;" id="<?=$item->id?>" data-title="<?=$item->name?>" class="label label-danger course">
                    <?=$item->name?>
                </a>
            </h4>
        </li>
        <?php
            }
        ?>
    </ul>
</div>
