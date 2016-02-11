<div id="w0" class="grid-view">
    <div class="col-md-8">
        <h3>Establishments</h3>
    </div>
    <div class="col-md-4">
        <button class="btn btn-danger" type="button" style="margin-top: 10px;  float: right;" id="add-establishment">Add Establishment</button>
    </div>
    <hr>
<table id="tbl-establishments" class="display dataTable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Location</th>
            <th>Rating</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach($establishments as $establishment){
    ?>
        <tr id='tr-<?=$establishment->id?>'>
            <td data-id='tr-<?=$establishment->id?>'>
            <a href="<?=\Yii::$app->urlManager->createUrl(['establishment/index', 'slug' => $establishment->slug]);?>" target="_blank"><?=$establishment->name;?></a>
            </td>    
            <td ><?=$establishment->establishmentsType->name?></td>
            <td><?=$establishment->location?></td>
            <td><?=$establishment->rating?></td>
            <td>
                <a data-id="<?=$establishment->id?>" class="edit-establishment" href="javascript:;">Edit</a>
                |
                <a data-id="<?=$establishment->id?>" class="delete-establishment" href="javascript:;">Delete</a>
            </td>
        </tr>
    <?php
        }
    ?>
    </tbody>
</table>
</div>
<script>
var gIndexEstablishments;
var gIndexEstablishmentsModal;

</script>
<?=$this->render('_index_establishments_modal',['establishments_model'=>$establishments_model])?>
<?php 
$this->registerJsFile(Yii::$app->homeUrl.'js/profile/_index_establishments.js',['depends' => 'yii\web\AssetBundle'] );
$this->registerJs($this->render('_index_establishments_js.php'));
?>
