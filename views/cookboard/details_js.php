<?php
    //if(!Yii::$app->user->isGuest && $model->user_id == Yii::$app->user->getId()){
    if($model->canEdit()){
?>
gCookboardDetails = Object.create(Cookboard.Details);
gCookboardDetails.baseUrl = '<?= Yii::$app->homeUrl;?>';
gCookboardDetails.init('cookboard');

gFormCookboard = Object.create(Cookboard.FormCookboard);
gFormCookboard.baseUrl = '<?= Yii::$app->homeUrl;?>';
gFormCookboard.init('form_cookboard');
<?php
    }
?>
setDIVHeight();

jQuery(".wrap-item-img2 .img-cntre").imgCentering();
jQuery(".cookboard-entryboard img").imgCentering();


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