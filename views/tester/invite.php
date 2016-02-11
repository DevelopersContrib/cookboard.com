 <script>
  window.fbAsyncInit = function() {
	FB.init({
	  appId      : '632973666810949',
	  xfbml      : true,
	  version    : 'v2.3'
	});
  };

  (function(d, s, id){
	 var js, fjs = d.getElementsByTagName(s)[0];
	 if (d.getElementById(id)) {return;}
	 js = d.createElement(s); js.id = id;
	 js.src = "//connect.facebook.net/en_US/sdk.js";
	 fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
   
   function invite(){
			   FB.ui({
	  method: 'send',
	  link: 'http://cookboard.com/cookboard/Scrumptious-Cakes/Spiced-Chocolate-cake',
	});
   }
</script>
	
<a href="#" onclick="invite();">invite</a>
<script type="text/javascript">
    var gPostEntryModal;
</script>
<a id="post" href="javascript:;">post</a>

<?= $this->render('//cookboard/_post_entry_modal',['cookboard'=>$cookboard,'cookboard_id'=>'','cookboardlist'=>$cookboardlist]); ?> 
<?php $this->registerJs("
	jQuery('#post').click(function(){
		gPostEntryModal.show();
	})

"); ?>