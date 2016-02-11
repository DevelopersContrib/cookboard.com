<?php
$this->registerCssFile(Yii::$app->homeUrl."css/contactus.css",['depends' => 'app\assets\AppAsset']);
?>
<!--<link rel="stylesheet" type="text/css" href="http://javapoint.com/css/serviceforms/contactus.css">-->

<div class="modal modal2 fade in" id="form-container">
 
  <div class="modal-header mh-2">
	<button type="button" class="close close-2" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3 class="text-center" id="form-header"><i class="icon-envelope-alt"></i> Contact Us Today !</h3>
  </div>
	
  <div class="modal-body mb-2">
    <div id="form-container-partner" style="display:none;">
		<div class="wrap-form2">
		<?php
		echo $this->render('//tester/serviceform/partner');
		?>
		</div>
	</div>
	<div id="form-container-inquire" style="display:none;">
		<?//include('serviceform/contact_us.php')?>
		<?php
		echo $this->render('//tester/serviceform/contact_us');
		?>
	</div>
	<div id="form-container-staffing" style="display:none;">
		<div class="wrap-form2">
		<?//include('serviceform/staffing.php')?>
		<?php
		echo $this->render('//tester/serviceform/staffing');
		?>
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