<?php
    if($canLike){
?>
gDetails = Object.create(Cookboard.Details);
gDetails.slug = '<?=$slug;?>';
gDetails.baseUrl = '<?=Yii::$app->homeUrl?>';
gDetails.likeUrl = '<?=Yii::$app->urlManager->createUrl(['boardentry/likes', 'slug' => $slug]);?>';
gDetails.init('details-container');

<?php
    }    
    if($canRate){
?>
gDetailsRating = Object.create(Cookboard.DetailsRating);
gDetailsRating.baseUrl = '<?=Yii::$app->homeUrl?>';
gDetailsRating.init('rating-container');

<?php
    }else{
?>
jQuery('.star').jRating({
    bigStarsPath:'<?=Yii::$app->homeUrl?>img/stars.png',
    smallStarsPath:'<?=Yii::$app->homeUrl?>img/stars.png',
    length : 5,
    rateMax: 5,
    isDisabled : true
});
<?php
    }
?>

jQuery('.totalrating').jRating({
    bigStarsPath:'<?=Yii::$app->homeUrl?>img/stars.png',
    smallStarsPath:'<?=Yii::$app->homeUrl?>img/stars.png',
    length : 5,
    rateMax: 5,
    isDisabled : true
});

setTimeout(function(){
	jQuery.ajax({
		type: 'post',
		//dataType: 'json',
		url: '<?=Yii::$app->homeUrl?>boardentry/ajaxp',
		data: {action:'related',slug:'<?=$slug;?>'},
		success: function(data){
			for(var x=0;x<data.items.length;x++){
				jQuery('#wrap-thumbnails').append('<a href="'+data.items[x].url+'"><img src="'+data.items[x].img+'"></a>');
			}
			if(jQuery('#wrap-thumbnails a').length>0)jQuery('#wrap-thumbnails-box').show();
			
		}
	}).complete(function () {
		
	});
},100);
<?php
if(!Yii::$app->user->isGuest){ ?>
    gPinForm = Object.create(Cookboard.PinForm);
    gPinForm.init('details-container');
<?php } ?>


var selectorE = 'a[data-imagelightbox="g"]';
var instanceE = $( selectorE ).imageLightbox(
{
    onStart:	 function() { navigationOn( instanceE, selectorE ); overlayOn(); },
    onEnd:		 function() { navigationOff(); activityIndicatorOff(); overlayOff(); },
    onLoadStart: function() { activityIndicatorOn(); },
    onLoadEnd:	 function() { navigationUpdate( selectorE ); activityIndicatorOff(); }
});




setDIVHeight();
        
jQuery(window).resize(function () {
	setDIVHeight();
});

function setDIVHeight() {
	var theDiv = jQuery('div#containerSetHeight');
	var divTop = theDiv.offset().top;
	var winHeight = $(window).height();
	var divHeight = winHeight - divTop;
	theDiv.height(divHeight);
}

jQuery('#wrapper-container').masonry({
	itemSelector : '.item'
});


jQuery(".wrap-imagePublicUser img").imgCentering();
<?php
	if(!empty($gocart)){
	?>
	setTimeout(function(){
		jQuery('#checkout').submit();
	},800);
	<?php
	}
?>