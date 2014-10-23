<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use Yii;

/* @var $this yii\web\View */
/* @var $model app\models\Tester */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tester-form">

    <form action="<?php echo Yii::$app->homeUrl;?>tester/link" method="POST">
	
		link: <input type="text" name="link" id="link"/>
		<?
			echo Yii::$app->z->hiddenCsrfToken();
		
		?>
		<button type="submit">submit</button>
	</form>

</div>
