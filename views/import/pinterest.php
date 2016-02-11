<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tester */


?>
<div class="tester-view">

    <h1>Import Photo</h1>

    <div class="widget-content" style="min-height: 251px;">	

						
			<?= $this->render('_submitlink', [
				'model' => $model,
			]) ?>
						
	</div>

  

</div>