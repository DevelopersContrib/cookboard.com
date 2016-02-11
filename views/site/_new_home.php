<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCss('
.ui-autocomplete-loading {
    background: white url("'.Yii::$app->homeUrl.'img/ui-anim_basic_16x16.gif") right center no-repeat;
}
.ui-autocomplete{
    z-index: 9999999;
}
');

?>
<div class="col-lg-12 col-md-12">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
            <div class="cook-landing">
                <h1>Your Local Food Marketplace! </h1>
		<h2>Discover New Dishes and Meet New Friends.</h2>
                <div class="cook-home-search">
                    <?php
                        $location = Yii::$app->getSession()->get('location');
                        $location = json_decode($location);
                        $country = $location->country_name;
                        $city = $location->city;
                        $place = '';
                        //var_dump($city,$country);
                        if($city === '(Private Address)' || $country ==='(Private Address)'
                            || $city === '(Unknown City?)' || $country ==='(Unknown Country?)'
                                ){
                            $place = '';
                        }else{
                            $place = $city;
                        }
                    ?>
                    <?php $form = ActiveForm::begin(['id'=>'search-form','method' => 'post', 'action'=>['search/index']]);?>
                        <?php /*?>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="" name="q">
                            <input id="city" name="city" type="hidden" value="<?=$place;?>" />
                            <div class="input-group-btn">
                                <button id="submit-search" class="btn btn-warning" type="submit">
                                Search
                                </button>
                            </div>
                        </div>
                        <?php */?>
                        <div class="col-md-5">
                                <input name="q" type="text" class="form-control" id="q" placeholder="Search For Food">
                        </div>
                        <div class="col-md-5">
                              <input id="city" name="city" type="text" class="form-control" id="" placeholder="City" value="<?=$place;?>">
                        </div>
                        <div class="col-md-2">
                        <button id="submit-search" type="submit" class="btn btn-warning">Search</button>
                        </div>
                     <?php ActiveForm::end(); ?>
                    <div class="clearfix"></div>
                 </div>
				<!-- city hashtag here -->
					<div class="hashtag">
						
						<?php
							foreach($cities as $city){
						?>
						<a href="javascript:;" title="<?=$city->city?>" data-search="<?=$city->city?>" class="city-link label label-warning"><?=strlen($city->city)>30?substr($city->city,0,30)."...":$city->city; ?></a>
						<?php
							}
						?>
						
						
					</div>
				<!-- end city hashtag -->
                <div class="cookb-search">
                    <?php
                        /*if(!empty($place)){
                    ?>
                        <h3>Searching in : 
                        <span class="cook-area"><?=$city?>, <?=$country?>
                        <div class="spinner">
                          <div class="bounce1"></div>
                          <div class="bounce2"></div>
                          <div class="bounce3"></div>
                        </div>
                        </span>

                        </h3>		
                    <?php }*/?>
                </div>
                <?php
                    if(Yii::$app->user->isGuest){
                ?>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 3cols">
                        <h2>Join As A</h2>
                        <div class="col-md-4">
                              <a href="<?=Yii::$app->urlManager->createUrl(['site/login']);?>" class="btn btn-large btn-block btn-warning choice show-details"><img src="http://d2qcctj8epnr7y.cloudfront.net/uploads/cook-l.png">&nbsp;Cook</a>
							  <div id="b-details">
								<div class="c-right">
									<img src="http://www.domaindirectory.com/images/icon/arrow-58-xxl.png" style="width:140px; margin-top:14px;">
								</div>
								<div class="c-left">
								<h3>Join as a <span>Cook</span></h3>
								<p>Share and sell your specialty food items to your community.</p>
								</div>
								<div style="clear:both"></div>
							</div>
						</div>
                        <div class="col-md-4">
                              <h4><span  class="line-center">OR</span></h4>
                        </div>
                        <div class="col-md-4">
                              <a href="<?=Yii::$app->urlManager->createUrl(['site/login']);?>" class="btn btn-large btn-block btn-warning choice show-details2"><img src="http://d2qcctj8epnr7y.cloudfront.net/uploads/restaurant-3-l.png">&nbsp;Foodie</a>
							  <div id="b-details2">
								<div class="f-left">
									<img src="http://www.domaindirectory.com/images/icon/arrow-58-xxl2.png" style="width:140px; margin-top:14px;">
								</div>
								<div class="f-right">
								<h3>Join as a <span>Foodie</span></h3>
								<p>Taste specialty food items from your community's local home cooks and chefs.</p>
								</div>
								<div style="clear:both"></div>
							  </div>
						</div>
						<!-- terms -->
						<div class="col-md-12 cterms" style="font-size: 100%; margin-top:-50px;">
								<a href="<?=Yii::$app->urlManager->createUrl(['site/about'])?>" class="label label-warning">About</a>
								<a href="<?=Yii::$app->urlManager->createUrl(['site/team'])?>" class="label label-warning">Team</a>
								<a href="<?=Yii::$app->urlManager->createUrl(['site/privacy'])?>" class="label label-warning">Privacy and Policy</a>
								<a href="<?=Yii::$app->urlManager->createUrl(['site/toc'])?>" class="label label-warning">Terms and Condition</a>
						   </div>
						<!-- end terms -->
                    </div>
                </div>				
                <?php
                    }
                ?>
            </div>
      </div>
    </div>
</div>
<?php $this->registerJs('jQuery("#submit-search").on("click",function(){jQuery("#search-form").submit();});'
        . ''
        . ''
        . 'jQuery(".city-link").click(function(){
				jQuery("#city").val(jQuery(this).attr("data-search"));
				jQuery("#submit-search").trigger("click");
		});'
        . 'jQuery("#q, #city").keypress(function(e){
            if(e.keyCode==13)
            jQuery("#submit-search").trigger("click");
        });'
        . ''
        . 'jQuery( "#city" ).autocomplete({
            source: function( request, response ) {
                jQuery.ajax({
                    url: "http://gd.geobytes.com/AutoCompleteCity",
                    dataType: "jsonp",
                    data: {
                        q: request.term
                    },
                    success: function( data ) {
                        var fdata = [];
                        for(var x = 0;x<data.length;x++){
                            try{
                                var arrData = data[x].split(",");
                                fdata.push(arrData[0]+","+arrData[2]);
                            }catch(e){}
                        }
                        if(fdata.length>0){
                            fdata = (data[0]==="")?data:fdata ;
                            response( fdata );
                        }else{
                            response( data );
                        }
                    }
                });
            },
            minLength: 3,
            select: function( event, ui ) {
                if(ui.item){
                }
            },
            open: function() {
                jQuery( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                jQuery( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
		
		
		jQuery.ajax({
			type: "post",
			dataType: "json",
			url: "/site/ajax",
			data: {action:"location"},
			success: function(data){
				
			}
		}).complete(function () {
			gLoading(false);
		});
		
		
		'); ?>