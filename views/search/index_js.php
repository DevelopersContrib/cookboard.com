<?php
    $location = Yii::$app->getSession()->get('location');
    $location = json_decode($location);
    $country = '';
    $city = '';
    if(!empty($location->city)){
        $country = $location->country_name;
        $city = $location->city;
    }
?>

jQuery.ajax({
	type: "post",
	dataType: "json",
	url: "/site/ajax",
	data: {action:"location"},
	success: function(data){
		
		gSearch = Object.create(Cookboard.Index);
		gSearch.baseUrl = '<?=Yii::$app->homeUrl;?>';
		try{
			//gSearch.address = '<?=$city.', '.$country;?>';
			gSearch.address = data.city+', '+data.country;
			<?php
			if(!empty($loc)){
			?>
					jQuery("#citySelect").val('<?=$loc?>');
			<?php
				}elseif($city!='(Unknown City?)' && $country!= '(Unknown Country?)'){?>
					//gSearch.find('#citySelect').val('<?=$city.', '.$country;?>');
			<?php
				}
			?>
			var script = document.createElement('script');
			script.type = 'text/javascript';
			script.src = 'https://maps.googleapis.com/maps/api/js?sensor=false&' +
					'callback=gSearch.mapIni';
			document.body.appendChild(script);

		}catch(e){}
		gSearch.init('containerSetHeight');

		<?php

		if($type === 'entry' && $total_result===0 && $_SERVER['REQUEST_METHOD'] == 'POST' && !Yii::$app->user->isGuest){
		?>
		gSearch.initWishlist();
		gSearch.confirmWishlist();
		<?php
		}?>
		
		<?php
		/*if(!$ispost){
		?>
			jQuery('body').append(
			'<div role="tooltip" class="popover text-center" id="popupsearchcity" style="max-width: 376px !important; display: block; top: 30%; left: 35%;">'+
			'<h3 class="popover-title">Search</h3><div style="margin:10px"><h1>Search posts in your city? '+
			'<button class="btn btn-danger btn-small" type="button" data-loading-text="Saving..." id="goto-city" style="padding: 2px 12px;">Yes</button> '+
			'<button id="closeme" style="padding: 2px 14px;" type="button" class="btn btn-warning btn-small">No</button></h1></div>'+
			'<div class="popover-content"></div></div>'
			);
			
			jQuery('#closeme').click(function(){
				jQuery('#popupsearchcity').remove();
			});
			
			jQuery('#goto-city').click(function(){
				jQuery('#popupsearchcity').remove();
				jQuery('#citySelect').focus();
			});
		<?php
		}*/
		?>
	}
}).complete(function () {
	
});


<?php
if(!Yii::$app->user->isGuest){ ?>
    gPinForm = Object.create(Cookboard.PinForm);
    gPinForm.init('containerSetHeight');
<?php } ?>

    
    <?php
    if(!empty($type)){
    ?>    
        //jQuery(".radio-<?=$type?>").trigger('click');
        
        jQuery('.city-container, .diet-container, .cuisine-container, .course-container').show();
        
        //if(jQuery(this).val()=='<?=$type?>'){
		if('<?=$type?>'=='board'){
            jQuery('.city-container, .diet-container, .cuisine-container, .course-container').hide();
        //}else if(jQuery(this).val()=='<?=$type?>'){
		}else if('<?=$type?>'=='user'){
            jQuery('.diet-container, .cuisine-container, .course-container').hide();
        }
    <?php
        }
    ?>   
    setTimeout(function(){
<?php
    if(!empty($q)){
?>    
    jQuery("#searchtext").val('<?=$q;?>');
<?php
    }
?>
    
<?php
    if(!empty($courseid)){
?>    
    jQuery("#courseSelect").select2("val", [<?=$courseid;?>]);
<?php
    }
?>
    
<?php
    if(!empty($cuisineid)){
?>    
    jQuery("#cuisineSelect").select2("val", [<?=$cuisineid;?>]);
<?php
    }
?>  
    
<?php
    if(!empty($dietid)){
?>    
    jQuery("#dietSelect").select2("val", [<?=$dietid;?>]);
<?php
    }
?>  
    
<?php
    if(!empty($loc)){
?>    
    jQuery("#citySelect").val('<?=$loc?>');
<?php
    }
?>  
    
},800);
    
    
jQuery(".wcca-img-featured img").imgCentering();

setDIVHeight();

jQuery(window).resize(function () {
    setDIVHeight();
});

function setDIVHeight() {
    var theDiv = jQuery('div#containerSetHeight');
    var divTop = theDiv.offset().top;
    var winHeight = jQuery(window).height();
    var divHeight = winHeight - divTop;
    theDiv.height(divHeight);
}
