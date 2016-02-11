 <form onsubmit="return sumbitCheck();" action="<?php echo Yii::$app->homeUrl;?>import/facebookphotos" method="POST">
 <?
			echo Yii::$app->z->hiddenCsrfToken();
		
?>
<div class="control-group">
	<label class="control-label">Select Album</label>
	<div class="controls">
		<select id="attributes" name="attributes">
			<option value ="1">Album1</option>
			<option value ="2">Album2</option>
			<option value ="3">Album3</option>
			<option value ="4">Album4</option>
			<option value ="5">Album5</option>
			<option value ="6">Album6</option>
		</select>
	</div>
</div>
<button type="submit">submit</button>
</form>