$(function(){
	$('#leadform').submit(function(){
		submitLead();
		return false;
	});
	
	$('#submitLead').click(function(){
		submitLead();
	});
	
	$('#_about').click(function(){
		$('#l_contactus').hide();
		$('#l_partner').hide();
		$('#l_apply').hide();
		$('#r_apply').hide();
		
		$('#non_terms').show();
		$('#f_terms').hide();
		$('#f_privacy').hide();
		
		$('#l_about').show('slow');
		$('#r_about').show();
		$('#_title').html('About');
	});
	$('#_contactus').click(function(){
		$('#l_about').hide();
		$('#l_partner').hide();
		$('#l_apply').hide();
		$('#r_apply').hide();
		
		$('#non_terms').show();
		$('#f_terms').hide();
		$('#f_privacy').hide();
		
		$('#l_contactus').show('slow');
		$('#r_about').show();
		$('#_title').html('Contact');
	});
	$('#_partner').click(function(){
		$('#l_about').hide();
		$('#l_contactus').hide();
		$('#l_contactus').hide();
		$('#l_apply').hide();
		$('#r_apply').hide();
		
		$('#non_terms').show();
		$('#f_terms').hide();
		$('#f_privacy').hide();
		
		$('#l_partner').show('slow');
		$('#r_about').show();
		$('#_title').html('Partner with');
	});
	$('#_apply').click(function(){
		$('#l_about').hide();
		$('#r_about').hide();
		$('#l_contactus').hide();
		$('#l_partner').hide();
		
		$('#non_terms').show();
		$('#f_terms').hide();
		$('#f_privacy').hide();
		
		$('#l_apply').show('slow');
		$('#r_apply').show();
		$('#_title').html('Staffing for');
	});

});

function submitLead(){	 
	var email = $('#email').val();
	var user_ip = $('#user_ip').val();
	var indexof = email.indexOf("@");
	var name = email.slice(0,indexof);
	var domain = $('#domain').val();
	$('#warning').remove();
			
	if(email==''){
		$('#leadcontent').append('<div class="span12 text-center" id="warning">* Email is required *</div>');
		$('#email').focus();
		return false;
	}else if(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i.test(email)==false){
		$('#leadcontent').append('<div class="span12 text-center" id="warning">* Please enter a valid email address *</div>');
		$('#email').focus();
		return false;
	}else{	
		$("#leadform").hide();	
		$('#leadcontent').append('<div class="span12" style="text-align:center;margin:20px 0 35px 0;color:white;min-height:20px;font-size:18px;" id="loading">Processing . . . Please wait . . .</div>');
		
				
			$.post("http://www.api.contrib.com/forms/saveleads",
				{   domain:domain,
					email:email,
					user_ip:user_ip
				},function(res){
					console.log(res);
					$("#loading").hide();								
						
					if(res.success=='false'){
						$('#leadcontent').append('<div class=" text-center" id="response">Something went wrong. Sorry for the inconvenience.</div>');
					}else if(res.success=='success'){
						$('#leadcontent').append('<div class=" text-center" id="response"><h3>Thanks, your spot is reserved!</h3> <br><br>Share '+domain+' with you friends to move up in line and reserve your username.<br><br>'+
						'<form target="_blank" action="http://www.contrib.com/signup/follow/'+domain+'" method="post">'+
						'<input type="hidden" id="pemail" name="email" value="'+email+'"/>'+
						'<button class="btn btn-warning">Continue to Follow '+domain+' Brand</button></form><br>'+
												  '<div class="span4"><h3>Who We Are</h3>'+
						'<p>This site is part of our Contrib network where we get people '+
						'who has time to contribute to global ventures and build sustainable companies.</p>'+
						'</div>'+
  						'<div class="span4"><h3>Contribute in a lot of Ways</h3>'+
						'<img src="http://rdbuploads.s3.amazonaws.com/infographic/contribute.png">'+
						'</div>'+
						'<div class="span4"><h3>Why contribute?</h3>'+
						'<p>When you contribute to help build and launch a Contrib venture, you can instantly create value to a venture and increase its theoretical value from $500 to $10,000.</p>'+
						'<h4>Monetizing your Free time</h4>'+
						'<ol>'+
						'<li> Monetize your free time and receive equity points which is our gauge for real equity shares. </li>'+
						'<li>Send us a Referral and well give you $5</li>'+
						'<li>Participate in challenges and win cash grants and equity shares. </li>'+
						'<li>Apply for eServices and finish tasks for $25 to your Paypal.</li>'+
						'</ol> </div>'+
						'<div style="padding:10px;width:30%;opacity:.9;margin:0px auto;background:#fafafa;border-radius:8px;color:#000 !important;"><p>To share with your friends, click &ldquo;Share&rdquo; and &ldquo;Tweet&rdquo;:</p>'+
						'<a href="http://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>'+
						'<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2F'+domain+'%2F&amp;layout=standard&amp;show_faces=true&amp;width=450&amp;action=like&amp;font&amp;colorscheme=light&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:80px;" allowTransparency="true"></iframe>'+
						'<div id="sharebuttons"><span id="facebook" style="margin:0 0 10px 60px"></span><span id="twitter"></span></div></div><div class="clearfix"></div>'+
						'<p><small>Your email will never be sold and kept strictly for notification when we launch!</small></p></div>');
					}else{
						$('#leadcontent').append('<div class=" text-center" id="response">'+res.success+'<br><br>Visit our <a href="http://www.contrib.com/brand/details/'+domain+'" target="_blank">'+domain.toUpperCase()+' brand page</a> for further details. <br><br>Thank you! <br>'+

						'<br></div>');
					}
				}
			);
			
				// SALESFORCE LEAD
				$.post("http://www.manage.vnoc.com/salesforce/addlead",
				{
					 'firstName':name,
					 'lastName':name,
					 'title':'',
					 'email':email,
					 'phone':'',
					 'street':'',
					 'city':'',
					 'country':'',
					 'state':'',
					 'zip':'',
					 'domain':domain,
					 'form_type':'Contrib Lead Version 2'
					 
				},function(data2){
						console.log(data2);
					}
				);
		/*
					
			//VNOC CAMPAIGN RESPONSE
			 $.post("http://manage.vnoc.com/campaignresponse/addContact",
			  { domain:domain,
				contact_name:name,
				contact_email:email
			  }
			  ,function(data){ console.log(data) });
				
			//VNOC LEADS
			$.post("http://manage.vnoc.com/subscribersubmit/add",
				{
					type:'LEADS',
					domain:domain,
					name: name,
					email: email
				}
				,function(data){}
			);
			*/			
			return false;
	}		
	return false;

}