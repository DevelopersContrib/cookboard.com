<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use Yii;

/* @var $this yii\web\View */
/* @var $model app\models\Tester */
/* @var $form yii\widgets\ActiveForm */
$this->title = "Import Pinterest Photos";
?>

<div class="tester-form">

    <form onsubmit="return sumbitCheck();" action="<?php echo Yii::$app->homeUrl;?>import/link" method="POST">
	
		link: <input type="text" name="link" id="link"/>
		<?
			echo Yii::$app->z->hiddenCsrfToken();
		
		?>
		<div id="pinwarning" style="display:none">
			<img src="http://cdn1.iconfinder.com/data/icons/silk2/exclamation.png">
			<span id="pinmsg"></span>
		</div>
		<button type="submit">submit</button>
	</form>

</div>

<script>
		function sumbitCheck(){
			var link = $('#link').val();
			var base_url = $('#base_url').val();
												
			var patt1 = /http:\/\/pinterest.com/i;
			var patt2 = /pins/i;
										
			if(link.match(patt2) && link.match(patt1)){
				return true;
			}else{
				$('#pinwarning').show();
				$('#pinmsg').html(' &nbsp; Invalid Pinterest pins link.');
				return false;
			}	
		}
		
		$(function(){
			$('#username').focus(function(){
				$('#pinwarning').hide();
				$('#pinmsg').html('');
			});
			
		});
</script>
