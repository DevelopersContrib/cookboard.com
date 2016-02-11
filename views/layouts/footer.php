<div class="footer-dark-1">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <h3 class="fnt-bold text-uppercase">
                            Cookboard.com
                        </h3>
                        <p>
                            is a new business model, Technology, and Solution targeting the premium domain channel with a fast, affordable, high quality business creation and management platform. 
                        </p>
                    </div>
                    <div class="col-md-3">
                        <h3 class="fnt-bold text-uppercase">
                            get started
                        </h3>
                        <ul class="list-unstyled f-a-links">
                            <li>
                                <a data-target="#form-container" data-toggle="modal" id="_partner" class="text-capitalize" href="">
                                    Partner with us
                                </a>
                            </li>
                            <li>
                                <a class="text-capitalize" href="" data-target="#form-container" data-toggle="modal" id="_apply">
                                    Apply now
                                </a>
                            </li>
                            <li>
                                <a class="text-capitalize" href="/referral">
                                    referral
                                </a>
                            </li>
                            <!--<li>
                                <a class="text-capitalize" href="">
                                    fund
                                </a>
                            </li>
                            <li>
                                <a class="text-capitalize" href="">
                                    developers
                                </a>
                            </li>-->
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h3 class="fnt-bold text-uppercase">
                            company
                        </h3>
                        <ul class="list-unstyled f-a-links f-a-links-mrgBtm">
                            <li>
                                <a class="text-capitalize" href="<?=Yii::$app->homeUrl;?>about">
                                    About us
                                </a>
                            </li>
                            <li>
                                <a class="text-capitalize" href="<?=Yii::$app->homeUrl;?>team">
                                    Team
                                </a>
                            </li>
                            <li>
                                <a class="text-capitalize" href="<?=Yii::$app->homeUrl;?>sitemap">
                                    Sitemap
                                </a>
                            </li>
                            <li>
                                <a class="text-capitalize" href="<?=Yii::$app->urlManager->createUrl(['site/privacy'])?>">
                                    Privacy policy
                                </a>
                            </li>
                            <li>
                                <a class="text-capitalize" href="<?=Yii::$app->urlManager->createUrl(['site/toc'])?>">
                                    Terms and Conditions
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h3 class="fnt-bold text-uppercase">
                            partners
                        </h3>
                        <p>
                            <a href="http://www.rackspace.com">
                                <img src="http://c15162226.r26.cf2.rackcdn.com/Rackspace_Cloud_Company_Logo_clr_300x109.jpg" alt="Rackspace" title="Rackspace" style="height:45px;">
                            </a>
                        </p>
                        <h3 class="fnt-bold text-uppercase">
                            Socials
                        </h3>
                        <ul class="list-inline socials-ul">
                            <li>
                                <a href="" class="icon-button twitter" title="twitter">
                                    <i class="fa fa-twitter"></i>
                                    <span></span>
                                </a>
                            </li>
                            <li>
                                <a href="" class="icon-button facebook" title="facebook">
                                    <i class="fa fa-facebook"></i>
                                    <span></span>
                                </a>
                            </li>
                            <li>
                                <a href="" class="icon-button google-plus" title="google-plus">
                                    <i class="fa fa-google-plus"></i>
                                    <span></span>
                                </a>

                            </li>

                            <li>
                                <a href="" class="icon-button youtube" title="youtube">
                                    <i class="fa fa-youtube"></i>
                                    <span></span>
                                </a>
                            </li>
                            <li>
                                <a href="" class="icon-button pinterest" title="pinterest">
                                    <i class="fa fa-pinterest"></i>
                                    <span></span>
                                </a>
                            </li>
                            <li>
                                <a href="" class="icon-button github" title="github">
                                    <i class="fa fa-github"></i>
                                    <span></span>
                                </a>
                            </li>
                            <li>
                                <a href="" class="icon-button linkedin" title="linkedin">
                                    <i class="fa fa-linkedin"></i>
                                    <span></span>
                                </a>
                            </li>
                        </ul>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer-dark-2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 f-a-links">
                        &copy; 2015 <a class="text-capitalize " href="">Cookboard.com</a>. All Rights Reserved. 
                    </div>
                    <!--<div class="col-md-6">
                        <ul class="list-inline text-right f-a-links">
                            <li>
                                <a class="text-capitalize" href="<?=Yii::$app->homeUrl;?>about">
                                    <i class="fa fa-bookmark-o"></i>
                                    About us
                                </a>
                            </li>
                            <li>
                                <a class="text-capitalize" href="<?=Yii::$app->homeUrl;?>team">
                                    <i class="fa fa-group"></i>
                                    Team
                                </a>
                            </li>
                            <li>
                                <a class="text-capitalize" href="<?=Yii::$app->homeUrl;?>sitemap">
                                    <i class="fa fa-sitemap"></i>
                                    Sitemap
                                </a>
                            </li>
                            <li>
                                <a class="text-capitalize" href="<?=Yii::$app->urlManager->createUrl(['site/privacy'])?>">
                                    <i class="fa fa-book"></i>
                                    Privacy policy
                                </a>
                            </li>
                            <li>
                                <a class="text-capitalize" href="<?=Yii::$app->urlManager->createUrl(['site/toc'])?>">
                                    <i class="fa fa-book"></i>
                                    Terms and Conditions
                                </a>
                            </li>
                        </ul>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    if(Yii::$app->user->isGuest){
?>
<script src="http://tools.contrib.com/cwidget?d=cookboard.com&p=sb&c=f"></script>
<?php	}
?>



<?php
$this->registerCssFile(Yii::$app->homeUrl."css/contactus.css",['depends' => 'app\assets\AppAsset']);
?>

<div class="modal fade" id="form-container" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal2">
            <div class="modal-header mh-2">
                <button type="button" class="close close-2" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="text-center" id="form-header"><i class="icon-envelope-alt"></i> Contact Us Today !</h3>
            </div>
            <div class="modal-body mb-2">
                <div id="form-container-partner" style="display:none;">
                    <div class="wrap-form2">
                        <?php
                        echo $this->render('//serviceform/partner');
                        ?>
                    </div>
                </div>
                <div id="form-container-inquire" style="display:none;">
                    <?php
                    echo $this->render('//serviceform/contact_us');
                    ?>
                </div>
                <div id="form-container-staffing" style="display:none;">
                    <div class="wrap-form2">
                        <?php
                        echo $this->render('//serviceform/staffing');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>	


<?php
$this->registerJs("
$(function(){
		$('button#show_partner_dialog, a#_partner').click(function(){
			hideOtherForms();
			$('#form-header').html(\"<i class='icon-envelope-alt'></i> Submit Partnership Application\");
			$('#form-container-partner').css('display','block');
		});
		
		$('a#_contactus').click(function(){
			hideOtherForms();
			$('#form-header').html(\"<i class='icon-envelope-alt'></i> Send Inquiry\");
			$('#form-container-inquire').css('display','block');
		});
		
		$('a#_apply').click(function(){
			hideOtherForms();
			$('#form-header').html(\"<i class='icon-envelope-alt'></i>  Submit Team Application\");
			$('#form-container-staffing').css('display','block');
		});
			
	});
	
	function hideOtherForms(){
		$('#form-container-partner').css('display','none');
		$('#form-container-inquire').css('display','none');
		$('#form-container-staffing').css('display','none');
	}

"); 
?>

<?php $this->registerJsFile(Yii::$app->homeUrl.'js/serviceforms/leads.js',['depends' => 'app\assets\AppAsset'] ); ?>
