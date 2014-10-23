gCookboard = Object.create(Cookboard.Index);
gCookboard.init('cookboard');

gFormCookboard = Object.create(Cookboard.FormCookboard);
gFormCookboard.baseUrl = '<?=Yii::$app->homeUrl;?>';
gFormCookboard.init('form_cookboard');

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