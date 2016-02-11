<?php
    $defaultlatlng = !empty($metadata['latlng'])?$metadata['latlng']:'';
    $address = !empty($metadata['location'])?$metadata['location']:'';
    $fname = !empty($metadata['first_name'])?$metadata['first_name']:'';
    $lname = !empty($metadata['last_name'])?$metadata['last_name']:'';
    $defaultlatlng = !empty($metadata['latlng'])?$metadata['latlng']:'';
?>
gMap = Object.create(Cookboard.Map);

gMap.defaultlatlng = '<?=$defaultlatlng?>';
gMap.address = '<?=$address?>';
gMap.name = '<?=$fname.', '.$lname?>';
gMap.load();