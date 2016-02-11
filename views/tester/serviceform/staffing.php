<?php
include 'variables.php';
$info['domain'] = $domain;
?>
						<div class="form-staffing1" id="staffing_step1">
							<div class="row-fluid">
								<div class="span12 text-center">
									
									<h4 class="text-capitalize">
										Apply Today for <?=ucfirst($info['domain'])?>
									</h4>
									<p class="blck-p">
										When you submit your registration, you can quickly join the <?=ucfirst($info['domain'])?>. team and take part in micro tasks and be paid in services fees, equity or performance equities.
									</p>
									<br>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span12">
									<form class="" onsubmit="return false;">
										<div class="step text-center">
											<h4>Step 1: <i class="icon-file-alt"></i> Submit an Application</h4>
											<p>You will receive an email when we approve your application.</p>
										</div>
										<div class="step text-center">
											<h4>Step 2: <i class="icon-tasks"></i> Start working on Tasks and Requests </h4>
											<p>Make money by getting equity or pay per performance for tasks rendered and service requests fulfilled.</p>
										</div>
										<p></p>
										<div class="group-form">
											<input type="text" class="input-block-level input-s1" id="staffing_initialemail" placeholder="Enter Email Address">
										</div>
										<span class="pull-left text-error" id="staffing_warning1"></span>
										<button type="submit" id="staffing_btn_1" class="btn btn-primary pull-right">
											Apply Today
											<i class="icon-circle-arrow-right"></i>
										</button>
									</form>
								</div>
							</div>
						</div>
						<div class="form-staffing2 hideIt" id="staffing_step2">
							<form class="" onsubmit="return false;">
								<div class="row-fluid">
									<div class="span12 text-center">
										<h4 class="text-capitalize">
											Apply Today for <?=ucfirst($info['domain'])?>
										</h4>
										<p class="blck-p">
											When you submit your registration, you can quickly join the <?=ucfirst($info['domain'])?>. team and take part in micro tasks and be paid in services fees, equity or performance equities.
										</p>
										<br>
									</div>
								</div>
								<div class="row-fluid">
									<div class="span6">
										<div class="group-form">
												<label>
													First Name
													<span class="text-error">*</span>
												</label>
											<input class="input-block-level input-s1" type="text" id="staffing_firstname">
										</div>
									</div>
									<div class="span6">
										<div class="group-form">
											<label>
												Last Name
												<span class="text-error">*</span>
											</label>
											<input class="input-block-level input-s1" type="text" id="staffing_lastname">
										</div>
									</div>
								</div>
								<div class="row-fluid">
									<div class="span6">
										<div class="group-form">
												<label>
													Email
													<span class="text-error">*</span>
												</label>
											<input class="input-block-level input-s1" type="text" id="staffing_email">
										</div>
									</div>
									<div class="span6">
										<div class="group-form">
											<label>
												Website
												<span class="text-error">&nbsp;</span>
											</label>
											<input class="input-block-level input-s1" type="text" id="staffing_website">
										</div>
									</div>
								</div>
								<div class="row-fluid">
									<div class="span6">
										<div class="group-form">
											<label>
												Country
												<span class="text-error">*</span>
											</label>
											<select class="input-block-level input-s1" id="staffing_country">
												<option value=""></option>									
												<?php for($ci=0;$ci<sizeof($countriesarray);$ci++){ ?>											
												<option value="<?=$countriesarray[$ci]['country_id']?>"><?=$countriesarray[$ci]['name']?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="span6">
										<div class="group-form">
											<label>
												City
												<span class="text-error">*</span>
											</label>
											<input class="input-block-level input-s1" type="text" id="staffing_city">
										</div>
									</div>
								</div>
								<div class="row-fluid">
									<div class="span6">
										<div class="group-form">
												<label>
													Password
													<span class="text-error">*</span>
												</label>
											<input class="input-block-level input-s1" type="password" id="staffing_password">
										</div>
									</div>
									<div class="span6">
										<div class="group-form">
											<label>
												Confirm Password
												<span class="text-error">*</span>
											</label>
											<input class="input-block-level input-s1" type="password" id="staffing_password2">
										</div>
									</div>
								</div>

								<div class="row-fluid">	
									<div class="span6 text-left">
										<div class="requiredFieldError" id="staffing_warning2"></div>
									</div>
									<div class="span6 text-right">
										<button type="submit" class="btn btn-primary" id="staffing_btn_2">Next <i class="icon-circle-arrow-right"></i></button>
									</div>
								</div>
							</form>
						</div>
						<div class="form-staffing3 hideIt" id="staffing_step3">
							<form class="" onsubmit="return false;">
								<div class="row-fluid">
									<div class="span12 text-center">
										<h4 class="text-capitalize">
											Apply Today for <?=ucfirst($info['domain'])?>
										</h4>
										<p class="blck-p">
											When you submit your registration, you can quickly join the <?=ucfirst($info['domain'])?>. team and take part in micro tasks and be paid in services fees, equity or performance equities.
										</p>
										<br>
									</div>
								</div>
								<div class="row-fluid">
									<div class="span12">
										<div class="group-form">
											<label>
												Team Role
												<span class="text-error">*</span>
											</label>
											<select class="input-s1 input-block-level" id="staffing_role">
												<option value=""></option>
												<?php for($ci=0;$ci<sizeof($rolesarray);$ci++){ ?>	
													<?if(!($rolesarray[$ci]['role_id'] == 29 || $rolesarray[$ci]['role_id'] == 11)){?>
														<option value="<?=$rolesarray[$ci]['role_id']?>"><?=$rolesarray[$ci]['role_name']?></option>
													<?php } ?>
												<?php } ?>
											</select>
										</div>
										<div class="group-form">
											<label>
												Resume link
												<span class="text-error">*</span>
											</label>
											<input class="input-block-level input-s1" type="text" id="staffing_resumeurl">
										</div>
										<div class="group-form">
											<label>
												Why you should join in our team?
												<span class="text-error">*</span>
											</label>
											<textarea class="input-block-level" rows="3" id="staffing_message"></textarea>
										</div>
										<div class="row-fluid">
											<div class="requiredFieldError" id="staffing_warning3" style="text-align:center"></div>	
											<button type="submit" id="staffing_btn_3" class="btn btn-primary pull-right">
												Next <i class="icon-circle-arrow-right"></i>
											</button>
											<button type="submit" id="staffing_back_3" class="btn btn-danger pull-left">
												<i class="icon-circle-arrow-left"></i>
												Back
											</button>											
										</div>
									</div>
								</div>
							</form>
						</div>
						<div class="form-staffing4 hideIt" id="staffing_step4">
							<form class="" onsubmit="return false;">
								<div class="row-fluid">
									<div class="span12 text-center">
										<h4 class="text-capitalize">
											Apply Today for <?=ucfirst($info['domain'])?>
										</h4>
										<p class="blck-p">
											When you submit your registration, you can quickly join the <?=ucfirst($info['domain'])?>. team and take part in micro tasks and be paid in services fees, equity or performance equities.
										</p>
										<br>
									</div>
								</div>
								<div class="row-fluid">
									<div class="span12 text-center">
										<div class="group-form">
											<img src="http://d2qcctj8epnr7y.cloudfront.net/images/icons/facebook.png">
											<input type="text" class="input-s1 input-large" id="staffing_facebook" placeholder="link to your facebook profile">
											<span>
												(optional)
											</span>
										</div>
										<div class="group-form">
											<img src="http://d2qcctj8epnr7y.cloudfront.net/images/icons/linkedin.png">
											<input type="text" class="input-s1 input-large" id="staffing_linkedin" placeholder="link to your linkedin profile">
											<span>
												(optional)
											</span>
										</div>
										<div class="group-form">
											<img src="http://d2qcctj8epnr7y.cloudfront.net/images/icons/github.png">
											<input type="text" class="input-s1 input-large" id="staffing_github" placeholder="link to your github profile">
											<span>
												(optional)
											</span>
										</div>
										<div class="group-form">
											<img src="http://d2qcctj8epnr7y.cloudfront.net/images/icons/skype.png">
											<input type="text" class="input-s1 input-large" id="staffing_skype" placeholder="your skype id">
											<span>
												(optional)
											</span>
										</div>
										<div class="group-form">
											<img src="http://d2qcctj8epnr7y.cloudfront.net/images/icons/yahoo.png">
											<input type="text" class="input-s1 input-large" id="staffing_yahoo" placeholder="your yahoo id">
											<span>
												(optional)
											</span>
										</div>
										<div class="group-form">
											<img src="http://d2qcctj8epnr7y.cloudfront.net/images/icons/gtalk.png">
											<input type="text" class="input-s1 input-large" id="staffing_talk" placeholder="your gtalk id">
											<span>
												(optional)
											</span>
										</div>
										<div class="group-form">
											<img src="http://d2qcctj8epnr7y.cloudfront.net/images/icons/aol.png">
											<input type="text" class="input-s1 input-large" id="staffing_aol" placeholder="your AOL id">
											<span>
												(optional)
											</span>
										</div>
										<div class="group-form">
											<img src="http://d2qcctj8epnr7y.cloudfront.net/images/icons/windows.png">
											<input type="text" class="input-s1 input-large" id="staffing_wlive" placeholder="your windows live id">
											<span>
												(optional)
											</span>
										</div>

										<div class="row-fluid">
											<div class="requiredFieldError" id="staffing_warning4"></div>	
											<button type="submit" class="btn btn-primary pull-right" id="staffing_btn_4">
												Next <i class="icon-circle-arrow-right"></i>
											</button>
											<button type="submit" class="btn btn-danger pull-left" id="staffing_back_4">
												<i class="icon-circle-arrow-left"></i>
												Back
											</button>
											<input type="hidden" id="staffing_domain" value="<?=$info['domain']?>">
										</div>
									</div>
								</div>
							</form>
						</div>
						<div class="form-staffing5 hideIt" id="staffing_final">
							<div class="row-fluid">
								<div class="span12 text-center">
									
									<h4 class="text-capitalize">
										Apply Today for <?=ucfirst($info['domain'])?>
									</h4>
									<h3 class="blck-p text-error">
										Thank you for your application.
									</h3>
									<p>
										You are now minutes away to joining <?=ucfirst($info['domain'])?> team.
									</p>
									<br>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span12">
									<p class="thnk-p">
										<b>1.</b>
										Click the link in the
										<span class="text-info">Verification email</span>
										that we have just sent you. If you still haven't received it, please check your spam inbox.
									</p>
									<p class="thnk-p">
										<b>2.</b>
										Your verification link will redirect you to our
										<a href="http://www.contrib.com" target="_blank">Marketpalce hub</a>
										where you can login and check out your application status.
									</p>
									<p class="thnk-p">
										<b>3.</b>
										You can now take part in actually building out an asset by sending proposals, partnering with brands, joining teams.
									</p>
									<br>
									<div id="viewcontriblink">Thank You!</div>
								</div>
							</div>
						</div>
						<?php $this->registerJsFile(Yii::$app->homeUrl.'js/serviceforms/staffing.js',['depends' => 'app\assets\AppAsset'] ); ?>			
						<!--<script src="/js/serviceforms/staffing.js"></script>-->
					
					