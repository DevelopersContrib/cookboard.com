<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="col-lg-4">
    <div class="wrap-rightSearchForm">
        <h3 class="font-bold font-raleways font-500 font-bold">
                Search for foods
        </h3>
        <p class="lead-Sub-desc font-raleways font-300">
                All you need to do is enter an igredient, a dish or a keyword. 
        </p>
        <p class="lead-Sub-desc font-raleways font-300">
                You can also select a specific category from the dropdown.
        </p>
        <p class="lead-Sub-desc font-raleways font-300 text-warning">
                There’s sure to be something tempting for you to try.
        </p>
        <p class="lead-Sub-desc font-raleways font-300">
                Enjoy!
        </p>
        <br>
        <?php $form = ActiveForm::begin(['id'=>'search-form','method' => 'post', 'action'=>['search/index']]);?>
            <div class="form-group">
                <input type="text" name="q" class="form-control" placeholder="Enter your search item">
            </div>
            <div class="form-group">
                <a id="submi-search" href="javascript:;" class="btn btn-warning btn-block btn-lg">
                    START COOKING!
                </a>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php $this->registerJs('jQuery("#submi-search").on("click",function(){jQuery("#search-form").submit();});'); ?>