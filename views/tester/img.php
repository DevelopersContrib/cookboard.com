<?php
$this->registerJs("


jQuery.ajax({
	type: 'post',
	dataType: 'json',
	url: '/boardentry/ajax',
	data: {action:'related',slug:'Red-Velvet-Cake'},
	success: function(data){
		
	}
}).complete(function () {
	
});


");
?>