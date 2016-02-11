<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Customer Info';
?>
<div class="row">
<div class="col-lg-6">    
    <div class="wrap-addFood-container font-raleways">
        
        <h2>Customer Payment Info</h2>
        <p>All fields are required.</p>
        
        <div class="row">
            <?php $form = ActiveForm::begin(['id'=>'customer_form','method' => 'post','action' => ['checkout/order'],]);?>    
            <div class="col-lg-12">
                <h3>First Name</h3>
            </div>
            <div class="col-lg-6">
            <?= $form->field($model, 'first_name',['template'=>'<span class="sr-only control-label">First Name</span>{input}{hint}{error}'])
                ->textInput(['class'=>'form-control','maxlength' => 255,'placeholder'=>'First Name']) ?>
            </div>
            
            <div class="col-lg-12">
                <h3>Last Name</h3>
            </div>
            <div class="col-lg-6">
            <?= $form->field($model, 'last_name',['template'=>'<span class="sr-only control-label">Last Name</span>{input}{hint}{error}'])
                ->textInput(['class'=>'form-control','maxlength' => 255,'placeholder'=>'Last Name']) ?>
            </div>
            
            <div class="col-lg-12">
                <h3>Address</h3>
            </div>
            <div class="col-lg-12">
            <?= $form->field($model, 'address',['template'=>'<span class="sr-only control-label">Address</span>{input}{hint}{error}'])
                ->textInput(['class'=>'form-control','maxlength' => 255,'placeholder'=>'Address']) ?>
            </div>
            
            <div class="col-lg-12">
                <h3>Zip Code</h3>
            </div>
            <div class="col-lg-6">
            <?= $form->field($model, 'zip',['template'=>'<span class="sr-only control-label">Zip Code</span>{input}{hint}{error}'])
                ->textInput(['class'=>'form-control','maxlength' => 255,'placeholder'=>'Zip Code']) ?>
            </div>
            
            <div class="col-lg-12">
                <h3>Contact Number</h3>
            </div>
            <div class="col-lg-6">
            <?= $form->field($model, 'contact_number',['template'=>'<span class="sr-only control-label">Contact Number</span>{input}{hint}{error}'])
                ->textInput(['class'=>'form-control','maxlength' => 255,'placeholder'=>'Contact Number']) ?>
            </div>
            
            <div class="col-lg-12">
                &nbsp;
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <?= Html::activeHiddenInput($model, 'id')?>
                    <button id="submit_entry" type="submit" class="btn btn-warning btn-block btn-lg">
                        <i class="fa fa-check"></i> Pay Now
                    </button>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <a href="<?=Yii::$app->urlManager->createUrl(['checkout/index']);?>" class="btn btn-info btn-block btn-lg">
                        <i class="fa fa-check"></i> Cancel
                    </a>
                </div>
            </div>
            
            <?php ActiveForm::end(); ?>
            
        </div>
    </div>
</div>
</div>