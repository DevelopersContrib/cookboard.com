<style>
.th-highlight {
	background:#F77F08;
	border:1px solid #333;
	box-shadow: 0px 10px 15px rgb(0, 0, 0);
}
</style>
<?php
    foreach($images as $img){
?>
<div class="col-xs-6 col-md-3">
	<a class="select-img" href="javascript:;">
	<div class="thumbnail">
		<?php /*?>
		<div class="sel-image">
		<input id="box" class="chk"  type="checkbox" value="<?=$img?>" style="display:none"/>
		<label for="box"></label>
		</div>
		<?php */?>
		<img src="<?=$img?>" alt="" />
	</div>
	</a>
 </div>
<?php
    }
?>