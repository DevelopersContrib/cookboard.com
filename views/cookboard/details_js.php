<?php
    if(!Yii::$app->user->isGuest){
?>
gCookboardDetails = Object.create(Cookboard.Details);
gCookboardDetails.baseUrl = '<?= Yii::$app->homeUrl;?>';
gCookboardDetails.init('cookboard');

<?php
    }
?>
setDIVHeight();

jQuery(".wrap-item-img2 .img-cntre").imgCentering();

$('.wcca-btn-actions').tooltip();

$(window).resize(function () {
    setDIVHeight();
});

function setDIVHeight() {
    var theDiv = $('div#containerSetHeight');
    var divTop = theDiv.offset().top;
    var winHeight = $(window).height();
    var divHeight = winHeight - divTop;
    theDiv.height(divHeight);
}

//$('#wrapper-container').masonry({
    //itemSelector : '.item'
//});