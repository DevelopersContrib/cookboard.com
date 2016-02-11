
gFormBoardEntry = Object.create(Cookboard.FormBoardEntry);
gFormBoardEntry.baseUrl = '<?=Yii::$app->homeUrl?>';

gFormBoardEntry.init('entry_form');
<?php
    if(count($model->boardEntryEstablishments)>0){
        $ids = '';
        foreach($model->boardEntryEstablishments as $establishment){
            $ids .= !empty($ids)?",\"$establishment->establishments_id\"":"\"$establishment->establishments_id\"";
        }
?>

jQuery("#establishments").select2("val", [<?=$ids;?>]);

<?php
    }
?>

<?php
    if(!empty($postimg)){
?>
    jQuery('.uploadOptions:eq( 1 )').prop('checked',true);
    jQuery('.uploadOptions:eq( 1 )').trigger('click');
    <?php
    for($x=0;$x<count($postimg);$x++){
    ?>        
        jQuery('.link-url:eq(<?=$x?>)').val('<?=$postimg[$x]?>');
    <?php
        if($x<count($postimg)-1){
    ?>
        jQuery('#add-link').trigger('click');
    <?php
        }
    }
    ?>
<?php
    }
?>

<?php
    $location = Yii::$app->getSession()->get('location');
    $country = '';
    $city = '';
    if($location){
        $location = json_decode($location);
        $country = $location->country_name;
        $city = $location->city;
    }
    if($model->isNewRecord){ 
?>
        try{
            gFormBoardEntry.address = '<?=$city.', '.$country;?>';
            <?php 
                if($city!='(Unknown City?)' && $country!= '(Unknown Country?)'){?>
                    gFormBoardEntry.find('.boardentry-city').val('<?=$city.', '.$country;?>');
            <?php
                }
            ?>
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://maps.googleapis.com/maps/api/js?sensor=false&' +
                    'callback=gFormBoardEntry.mapIni';
            document.body.appendChild(script);

        }catch(e){}
<?php     
    }else{?>
        gFormBoardEntry.address = '<?=$model->city?>';
        gFormBoardEntry.defaultlatlng = '<?=$model->latlng?>';

        <?php
            if(empty($model->city) && empty($model->latlng)){
        ?>
                gFormBoardEntry.address = '<?=$city.', '.$country;?>';
        <?php
            }
        ?>
        try{
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://maps.googleapis.com/maps/api/js?sensor=false&' +
                    'callback=gFormBoardEntry.mapIni';
            document.body.appendChild(script);
        }catch(e){}
<?php 
    } 
?>
