<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Cookboard';
if(!Yii::$app->user->isGuest){
    $this->params['breadcrumbs'] =[
        ['label' => 'Cook Board','url' => ['cookboard/index'],],
        $this->title,
    ];
}else{
    $this->params['breadcrumbs'] =[
        $this->title,
    ];
}

if($flash = Yii::$app->session->getFlash('msg')){
    echo Yii::$app->z->alert($flash);
}

$this->registerCss('
.highlight{
    border:1px solid red;
}
.highlight:hover{
    border:1px solid red;
}
');

?>

<style>
input.chk[type="radio"],
input.chk[type="checkbox"] {
  display:none;
}

input.chk[type="radio"] + span:before,
input.chk[type="checkbox"] + span:before {
  position: relative;
  top: 1px;
  display: inline-block;
  font-family: 'Glyphicons Halflings';
  font-style: normal;
  font-weight: 400;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
input.chk[type="checkbox"] + span:before {
  content: "\e157"; /* unchecked */
  border-radius:6px;
}

input.chk[type="checkbox"]:checked + span:before {
  content: "\e067";; /* check */  
  border-radius:6px;
  background:#fafafa;
}
.pl-hdbg {
background:#f5f5f5;
}
.pltop {
margin:10px 0px;
}
.plbtn {
font-size: 23px;
}
.pl-bdr {
border-bottom:1px solid #ccc;
margin-bottom:20px;
display:none;
}
.plbody{
padding:0px;
}
.pl-img-list {
margin-bottom:60px;
}
.plcon {
margin-left: -40px;
}
.plcon li {
background:#fafafa;
list-style-type:none;
margin: 5px;
}
.plcon .col-md-3 {
    width: 24%;
}
.pl-img {
margin-top: -75px;
width:100%;
height:150px;
background: #eee;
padding: 5px;
border: 1px solid #ccc;
}
.plbody span{
font-size:50px;
margin-left: 10px;
color: #F77F08;
}
.plcon .col-md-3 {
padding-right:0px;
padding-left:0px;
}
.plcon .checkbox label, .radio label {
padding: 0px 10px;
}
.seltel {
	margin-left: 5px;
	font-size: 28px;
}
body {
	background:#DECEB9;
}
.breadcrumb {
	display:none;
}
.footer {
	display: none;
}
</style>

<div id="wrapper-container"  class="row wrapper-container">
    <div id="containerSetHeight">
		<?php /*?>
        <div class="row">
            <a class="btn btn-warning" href="javascript:;" id="continue-create-entry">Post Selected</a>
        </div>
        <div class="row row2">
            
        </div>
		<?php */?>
		
		<div class="row">
			<div class="col-md-4">
				<h3 class="seltel"><i class="fa fa-hand-o-right"></i>&nbsp;Select Images To Post</h3>
			</div>
			<div class="col-md-4" style="text-align: center;">
				<h3><a href="javascript:;" type="button" class="btn btn-warning plbtn" id="continue-create-entry">Post It!</a></h3>
			</div>
			
			<div class="col-md-4"></div>
			<div class="col-md-12">
				<div class="pl-bdr"></div>			
			</div>
			
			<div class="col-md-12">	
				<div class="pl-img-list">
					<ul class="plcon">
					</ul>
				</div>
			</div>
		</div>
   </div> 
</div> 




<script type="text/javascript">
    var gAddEntryModal;
</script>
<?php
    $this->registerJs($this->render('index_js.php'));
?>
<?= $this->render('_add_entry_modal',['cookboardlist'=>$cookboardlist, 'cookboard'=>$cookboard]); ?>