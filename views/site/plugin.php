<?php
    $this->title = 'Plugins';
?>
<div class="container">
	<div class="row">
	  <div class="col-md-8 col-md-offset-2">
		<div class="plugin-page">
			<div class="plugin-title">			
			<img src="http://template.cookboard.com/img/plugin_icon.jpg">
			<h1>Cookboard Plugin</h1>
			</div>
			<div class="clearfix"></div>
			<p class="plugin-desc">Cookboard browser add-on will allow users to pin photos to their Cookboard.</p>
			<div class="clearfix"></div>
			<div class="pl-browsers">
				<a href="https://addons.mozilla.org/en-US/firefox/addon/cookboard-addon/" target="_blank" class="pl-firefox">
					<img src="http://template.cookboard.com/img/plugin-xxl-2.png">
					<h3>Plugin for Firefox</h3>				
				</a>
				<div class="clearfix"></div>
				<a href="#" target="_blank" class="pl-chrome">
					<img src="http://template.cookboard.com/img/plugin-xxl.png">
					<h3>Plugin for Chrome</h3>				
				</a>
			</div>
			<div class="screenshots">
				<h3>Screenshot:</h3>
				<img src="http://template.cookboard.com/img/sc.png">
			</div>
		</div>
	  </div>
	</div>
</div>
<style>
.plugin-page {
	background:#ffffff;
	padding:30px;
	box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.2);
	text-align:center;
	margin-bottom:30px;
}
.plugin-page .plugin-title img {
	width:110px;
}
.plugin-page .plugin-desc {
	border-top:1px dashed #ccc;
	border-bottom:1px dashed #ccc;
	padding:8px 0px;
	margin-bottom:20px;
}
.pl-browsers {
	text-align:left;
	padding:0px 40px;
}
.pl-firefox, .pl-chrome {
	display:block;
	background:#fafafa;
	margin-bottom:10px;
	border:1px solid #dedede;
	padding:15px;
}
.pl-firefox:hover, .pl-chrome:hover {
	border:1px solid #FA741D;
}
.pl-browsers .pl-firefox img {
	float:left;
	width:70px;
}
.pl-browsers .pl-chrome img {
	float:left;
	width:70px;
}
.pl-browsers h3 {
	vertical-align: -35px;
	display: inline-block;
	margin-left: 10px;
	font-size: 29px;
}
.screenshots {
	border-top:1px solid #ccc;
	margin-top:20px;
}
.screenshots img {
	max-width:100%;
	width:auto;
	border: 10px solid #ccc;
	border-radius:10%;
}
</style>