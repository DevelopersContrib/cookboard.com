
<a id="fblogin" href="#" >login</a>
<br>
<a id="fblogout" href="#" >logout</a>


<div id="status">
</div>
<script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }


  window.fbAsyncInit = function() {
	  FB.init({
		appId      : '632973666810949',
		cookie     : true,  // enable cookies to allow the server to access 
							// the session
		xfbml      : true,  // parse social plugins on this page
		version    : 'v2.2' // use version 2.2
	  });

	  FB.getLoginStatus(function(response) {
		statusChangeCallback(response);
	  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, name:' + response.name + ',  id:'+response.id+', email:'+response.email;
    });
  }
  
  function fb_logout(){
	FB.logout(function(response) {
	  // user is now logged out
	});
  }
  function fb_login(){
    FB.login(function(response) {

        if (response.authResponse) {
            console.log('Welcome!  Fetching your information.... ');
            //console.log(response); // dump complete info
            access_token = response.authResponse.accessToken; //get access token
            user_id = response.authResponse.userID; //get FB UID

            FB.api('/me', function(response) {
                user_email = response.email; //get user email
				// you can store this data into your database        

				console.log('Successful login for: ' + response.name);
				document.getElementById('status').innerHTML =
					'Thanks for logging in, name:' + response.name + ',  id:'+response.id+', email:'+response.email;		  
            });

        } else {
            //user hit cancel button
            console.log('User cancelled login or did not fully authorize.');
        }
    }, {
        scope: 'public_profile,email'
    });
}

</script>
<?php $this->registerJs($this->render('fb_js.php')); ?>