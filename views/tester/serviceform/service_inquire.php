<?php
include 'variables.php';
$info['domain'] = $domain;
?>	
 			<div class="row-fluid"> 
 				<div class="inquiryMainCont" id="inquiry_step1"> 
                     <h2 class="ttleCapt">Inquire about <?=ucwords($info['domain'])?></h2> 
                     <div class="formDesc"> 
                         <small> 
                             Enter a correct email, your email and inquiry will be deemed private but you will receive a response from our team as soon as we receive your inquiry.   
                         </small> 
                     </div> 
                     <div class="stepsMain"> 
                         <div class="step text-center"> 
                             <h4>Step 1: <i class="icon-file-alt"></i> Submit Your Inquiry</h4> 
                             <p>If you have questions, feel free to contact us.</p> 
                         </div> 
                         <div class="step text-center"> 
                             <h4>Step 2: <i class="icon-tasks"></i>We Will Contact You Shortly</h4> 
                             <p>You will receive an email addressing your concern.</p> 
                         </div> 
                     </div> 
                     <div class="row-fluid"> 
                         <form class="" onsubmit="return false;"> 
                             <div class="emailContainer"> 
                                 <div class="pull-left s3Input"> 
                                     <input class="s1Input input-block-level" type="text" id="inquiry_initialemail" placeholder="Enter e-mail address" /> 
                                 </div> 
                                 <div class="clearfix"></div> 
                             </div> 
                             <div class="form-actions f-a-style"> 
                                 <span class="pull-left text-error" id="inquiry_warning1"></span> 
                                 <button type="submit" class="btn blue pull-right" id="inquiry_btn_1">Apply Today <i class="icon-circle-arrow-right"></i></button> 
 								<input type="hidden" id="inquiry_domain" value="<?=$info['domain']?>"> 
                             </div> 
                         </form> 
                     </div> 
                 </div>  
 				<div class="inquiryMainCont" id="inquiry_step2" style="display:none"> 
                     <h2 class="ttleCapt">Inquire about <?=ucwords($info['domain'])?></h2> 
                     <div class="formDesc"> 
                         <small> 
                             Enter a correct email, your email and inquiry will be deemed private but you will receive a response from our team as soon as we receive your inquiry.   
                         </small> 
                     </div> 
 					<form class="" onsubmit="return false;"> 
 						<div class="row-fluid">						 
 							<div class="formTwo 1"> 
 								<label for="inquiry_firstname" class="control-label"> 
 									First Name <i class="text-error">*</i> 
 								</label> 
 								<input class="s1Input input-block-level" type="text" id="inquiry_firstname" /> 
 							</div> 
 							<div class="formTwo"> 
 								<label for="inquiry_lastname" class="control-label"> 
 									Last Name <i class="text-error">*</i> 
 								</label> 
 								<input class="s1Input input-block-level" type="text" id="inquiry_lastname" /> 
 							</div> 
 							<div class="formTwo 1">	 
 								<label for="inquiry_email" class="control-label"> 
 									Email <i class="text-error">*</i> 
 								</label> 
 								<input class="s1Input input-block-level" type="text" id="inquiry_email" placeholder="Email" /> 
 							</div> 
 							<div class="formTwo">	 
 								<label for="inquiry_company" class="control-label"> 
 									Contact Number <i class="text-error">*</i> 
 								</label> 
 								<input class="s1Input input-block-level" type="text" id="inquiry_contact" /> 
 							</div>					 
 							<div class="formTwo 1">		 
 								<label for="inquiry_country" class="control-label"> 
 									Country <i class="text-error">*</i> 
 								</label> 
 								<select class="selectS2 input-block-level" name="" id="inquiry_country"> 
									<option value=""></option>
 									<?php for($ci=0;$ci<sizeof($countriesarray);$ci++){ ?>											
										<option value="<?=$countriesarray[$ci]['country_id']?>"><?=$countriesarray[$ci]['name']?></option>
									<?}?>
 								</select> 
 							</div> 
 							<div class="formTwo">	 
 								<label for="inquiry_city" class="control-label"> 
 									City <i class="text-error">*</i> 
 								</label> 
 								<input class="s1Input input-block-level" type="text" id="inquiry_city" /> 
 							</div> 
 							<div class="formTwo 1">		 
 								<label for="inquiry_password" class="control-label"> 
 									Password <i class="text-error">*</i> 
 								</label> 
 								<input class="s1Input input-block-level" type="password" id="inquiry_password" /> 
 							</div> 
 							<div class="formTwo">	 
 								<label for="inquiry_cpassword" class="control-label"> 
 									Confirm Password <i class="text-error">*</i> 
 								</label> 
 								<input class="s1Input input-block-level" type="password" id="inquiry_password2" /> 
 							</div>					 
 							<div class="formTwo" style="width:99%">	 
 								<label for="partner_message" class="control-label"> 
 									Message <i class="text-error">*</i> 
 								</label> 
 								<textarea class="textS2 input-block-level" id="inquiry_message" rows="4"></textarea> 
 							</div> 
 						</div> 
 						<div class="row-fluid"> 
 							<div class="requiredFieldError" id="inquiry_warning2"></div> 
 							<div class="form2Button"> 
 								<button type="submit" class="btn blue" id="inquiry_btn_2" style="float: right;">Next <i class="icon-circle-arrow-right"></i></button> 
 							</div> 
 						</div> 
 					</form> 
                 </div>        
 			 	<div class="inquiryMainCont" id="inquiry_final" style="display:none"> 
 					<h2 class="ttleCapt">Inquire about <?=ucwords($info['domain'])?></h2> 
 					<hr /> 
 					<h4 class="text-error text-center" style="line-height: 24px;">Thank you for contacting us.</h4> 
 					<div class="formDesc2 text-center"> 
 					<small>You are now minutes away to joining <?=ucwords($info['domain'])?> team.</small><br>
  <br>
 						<ol>
 <li>
  <small>
   Click the link in the <span class="text-info">Verification email</span> that we have just sent you. If you still haven't received it, please check your spam inbox.
  </small>
 </li>
 <li>
  <small>
   Your verification link will redirect you to our <a target="_blank" href="http://www.contrib.com">Marketpalce hub</a> where you can login and check out your application status.
  </small>
 </li>
 <li>
  <small>
   You can now take part in actually building out an asset by sending proposals, partnering with brands, joining teams.
  </small>
 </li>
</ol> 
<br><br>
							<div id="viewcontriblink">Thank You!</div>
 					</div> 
 				</div> 
 			</div>	 
<?php $this->registerJsFile(Yii::$app->homeUrl.'js/serviceforms/service_inquiry.js',['depends' => 'app\assets\AppAsset'] ); ?>			
<!--<script src="<?php echo $base_url?>js/serviceforms/service_inquiry.js"></script>-->