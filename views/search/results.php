<?php
    if(count($models)>0){
        if($type==='board'){
            foreach($models as $board){
                echo $this->render('_board',['item'=>$board]);
            }
        }elseif($type==='user'){
            foreach($models as $user){
                echo $this->render('_user',['item'=>$user]);
            }
        }else{
            foreach($models as $entry){
                echo $this->render('_entry',['item'=>$entry]);
            }
        }
    }else{
		$c = empty($loc)?'':" in $loc";
		$m = empty($q)?'':" for $q";
		$msg = 'Oops no cookboard entries found'.$m.$c;
        echo '<div style="padding:15px; text-align:center;"><h2 style="background:#fff; padding:16px; font-size:35px; color:#7F5217;"><i class="fa fa-exclamation-triangle"></i>&nbsp;'.$msg.'</h2></div>';         
        if($type === 'entry'){
            ?>
            <a style="opacity:0;width: 1px;"  tabindex="0" class="mWishlist btn btn-lg btn-danger" role="button" data-toggle="popover" data-trigger="focus" title="Search">popover</a>
            <?php
            $this->registerJs("gSearch.initWishlist();
                gSearch.confirmWishlist();"); 
        }
    }
?>

<div class="col-lg-12 text-center">
    <?php
        echo app\components\LinkPagerCustom::widget([
            'pagination' => $pages,
        ]);
    ?>
</div>
