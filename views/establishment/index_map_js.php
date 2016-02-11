<?php
    $address = $model->location;
    $defaultlatlng = '';
    $name = $model->name;
?>
gMap = Object.create(Cookboard.Map);

gMap.defaultlatlng = '<?=$defaultlatlng?>';
gMap.address = '<?=$address?>';
gMap.name = '<?=$name?>';

gMap.load();