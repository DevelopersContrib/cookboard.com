<?php
    $this->title = 'Team';
?>
<style>
body {
	overflow-x:hidden;
}
.sub-head {
	background: url(http://rdbuploads.s3.amazonaws.com/uploads/cookboard/cookboard-photoshoot.jpg);
	margin-left: -150px;
	margin-right: -150px;
	margin-top: -21px;
	padding: 120px 0px;
	text-align:center;
}
.sub-head h1 {
	color:#fff;
	text-shadow: 4px 4px 3px #000;
	font-size: 70px;
	margin: 0px;
}
.container-2 {
	background: none repeat scroll 0% 0% #FFF;
	margin-top: -40px;
	box-shadow: 0px 0px 6px #000;
	border-radius: 8px 8px 0px 0px;
	width:980px !important;
	padding-bottom: 50px;
}
@media all and (max-width: 600px) {
    .container-2  {
        width:auto !important;
    }
}
@media all and (max-width: 600px) {
    .sub-head h1  {
        font-size: 35px !important;
    }
}
@media all and (max-width: 600px) {
   .team-box-div {
    width: 100% !important;
	}
}
.side-here {
	margin-top:20px;
}
.side-here li {
	margin-bottom:20px;
}
.team-box-div .teambox {
    background: none repeat scroll 0% 0% #F5F5F5 !important;
}
</style>
<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
?>
<div class="sub-head">
	<div class="container">
	<h1>Cookboard Team</h1>
	</div>
</div>
<div class="container container-2">
	<div class="site-about">
		<h1><?= Html::encode($this->title) ?></h1>

		<script type="text/javascript" src="http://www.contrib.com/widgets/teammembersperdomain/cookboard.com"></script>

	</div>
</div>
