<?php
	function createApiCall($url, $method, $headers, $data = array(),$user=null,$pass=null)
	{
			if (($method == 'PUT') || ($method=='DELETE'))
			{
				$headers[] = 'X-HTTP-Method-Override: '.$method;
			}

			$handle = curl_init();
			curl_setopt($handle, CURLOPT_URL, $url);
			curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
			if ($user){
			 curl_setopt($handle, CURLOPT_USERPWD, $user.':'.$pass);
			} 

			switch($method)
			{
				case 'GET':
					break;
				case 'POST':
					curl_setopt($handle, CURLOPT_POST, true);
					curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($data));
					break;
				case 'PUT':
					curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'PUT');
					curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($data));
					break;
				case 'DELETE':
					curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'DELETE');
					break;
			}
			$response = curl_exec($handle);
			return $response;
	}

    $this->title = 'Referral';
	$domain = $_SERVER["HTTP_HOST"];
	$domain = str_replace("http://","",$domain);
	$domain = str_replace("www.","",$domain);
	$info['domain'] = $domain;
	$info['logo'] = 'http://d2qcctj8epnr7y.cloudfront.net/images/2013/logo-CookBoard-2.png';
	$info['domainid'] = 23135;
	
	//get domain affiliate id
	$headers = array('Accept: application/json');
    $url = $api_url.'getdomainaffiliateid?domain='.$domain.'&key='.$key;
    $result = createApiCall($url, 'GET', $headers, array());
    $data_domain_affiliate = json_decode($result,true);
    if ($data_domain_affiliate['success']){
    	$domain_affiliate_id = $data_domain_affiliate['data']['affiliate_id'];
    }else {
    	$domain_affiliate_id = '391'; //contrib.com affiliate id
    }
    $domain_affiliate_link = 'http://referrals.contrib.com/idevaffiliate.php?id='.$domain_affiliate_id.'&url=http://www.contrib.com/signup/firststep?domain='.$domain;
	
	
?>
<style>
    .padd-banner{
        padding: 10px 20px;
        width: 65%;
        margin: auto;
    }
    .banner-main{
        margin-bottom: 30px;
        padding-bottom:10px;
        border-bottom: 1px solid #000;
    }
    .banner-main textarea{
        resize:none;
        border-radius: 4px;
    }
    .banner-main:last-child{
        border-bottom: none;
    }
    .banner-header{
        font-weight: 300;
        border-bottom: 1px solid #000;
        line-height: 65px;
        margin:0 0 30px;
        color: #000;
    }
    .banner-img-cont{
        margin-bottom: 25px;
    }
    .banner-source{
        color: #000;
        font-size:18px;
    }
    .banner-info{
        color: #000;
    }
    /*
    ==============================================
    tossing
    ==============================================
    */

    .tossing{
        animation-name: tossing;
        -webkit-animation-name: tossing;

        animation-duration: 2.5s;
        -webkit-animation-duration: 2.5s;

        animation-iteration-count: infinite;
        -webkit-animation-iteration-count: infinite;
    }

    @keyframes tossing {
        0% {
            transform: rotate(-4deg);
        }
        50% {
            transform: rotate(4deg);
        }
        100% {
            transform: rotate(-4deg);
        }
    }

    @-webkit-keyframes tossing {
        0% {
            -webkit-transform: rotate(-4deg);
        }
        50% {
            -webkit-transform: rotate(4deg);
        }
        100% {
            -webkit-transform: rotate(-4deg);
        }
    }
    /*
    ==============================================
    floating
    ==============================================
    */

    .floating{
        animation-name: floating;
        -webkit-animation-name: floating;

        animation-duration: 1.5s;
        -webkit-animation-duration: 1.5s;

        animation-iteration-count: infinite;
        -webkit-animation-iteration-count: infinite;
    }

    @keyframes floating {
        0% {
            transform: translateY(0%);
        }
        50% {
            transform: translateY(8%);
        }
        100% {
            transform: translateY(0%);
        }
    }

    @-webkit-keyframes floating {
        0% {
            -webkit-transform: translateY(0%);
        }
        50% {
            -webkit-transform: translateY(8%);
        }
        100% {
            -webkit-transform: translateY(0%);
        }
    }
</style>
<style>
    .animated {
        -webkit-animation-duration: 1s;
        animation-duration: 1s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
    }
    @-webkit-keyframes rotateIn {
        0% {
            -webkit-transform-origin: center center;
            transform-origin: center center;
            -webkit-transform: rotate(-200deg);
            transform: rotate(-200deg);
            opacity: 0;
        }

        100% {
            -webkit-transform-origin: center center;
            transform-origin: center center;
            -webkit-transform: rotate(0);
            transform: rotate(0);
            opacity: 1;
        }
    }

    @keyframes rotateIn {
        0% {
            -webkit-transform-origin: center center;
            -ms-transform-origin: center center;
            transform-origin: center center;
            -webkit-transform: rotate(-200deg);
            -ms-transform: rotate(-200deg);
            transform: rotate(-200deg);
            opacity: 0;
        }

        100% {
            -webkit-transform-origin: center center;
            -ms-transform-origin: center center;
            transform-origin: center center;
            -webkit-transform: rotate(0);
            -ms-transform: rotate(0);
            transform: rotate(0);
            opacity: 1;
        }
    }
    .rotateIn {
        -webkit-animation-name: rotateIn;
        animation-name: rotateIn;
    }
    .r-d{
        -webkit-animation-delay: 2.5s;
        -moz-animation-delay: 2.5s;
        -ms-animation-delay: 2.5s;
        -o-animation-delay: 2.5s;
        animation-delay: 2.5s;
    }
    .arrw-rela {
        position: relative;
    }
    .arrw-point-white {
        background: url("http://d2qcctj8epnr7y.cloudfront.net/contrib/arrow-1-medium.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
        height: 92px;
        left: -130px;
        position: absolute;
        top: -75px;
        width: 100px;
    }
    .badge-postn{
        position: absolute;
        z-index: 10;
        top: 30px;
        right: 90px;
    }
    /* Landscape phones and down */
    @media (max-width: 480px) {
        .badge-postn{
            position: absolute;
            right: 1px;
            top: 2px;
            width: 40px;
            z-index: 10;
        }
        .email-glow input[type="text"] {
            height: 40px;
            width: 163px !important;
        }
        .wrap-email-input{
            width:250px;
        }
        .phne-s1{
            font-size: 14px;
        }
        .span4.features{
            text-align: center;
        }
        .img-phone{
            margin:auto;
        }
        .p-phone{
            text-align:center;
        }
    }
</style>
<style type="text/css">
    /* Add New 2 banner */
    .wrap-allbanner{
        background: url(http://d2qcctj8epnr7y.cloudfront.net/images/2013/banner-contrib-728x90-1.png)no-repeat scroll;
        height: 90px;
        width: 728px;
        position: relative;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .bannerType1{
        text-decoration: none;
    }
    .bannerType1, .bannerType1:focus,.bannerType1:hover{
        outline: none;
    }
    .wrap-bannerLeft, .wrap-bannerRight{
        display: inline-block;
        float: left;
    }
    /* Left COntainer */
    .wrap-bannerLeft{
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        height: 90px;
        vertical-align: top;
        padding: 15px 5px 20px 10px;
        width: 245px;
        overflow: hidden;
		
    }
    /*Link Domain*/
    .ellipsis {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .aBnnrP{
        display: block;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        font-weight: bold;
        font-size: 22px;
        line-height: normal;
        margin: 0;
        color: #0088CC;
        text-align: center;
        text-transform: capitalize;
        text-decoration: none;
    }

    /* Right Container */
    .wrap-bannerRight{
        color: #FFFFFF;
        height: 90px;
        margin-left: 84px;
        width: 397px;
    }
    .content-rightText{
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        width: 350px;
        padding-top: 16px;
        margin: auto;
    }
    .content-rightText span{
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        display: block;
    }
    .content-rightText span, .content-rightText p{
        font-size: 25px;
        text-align: center;
        text-shadow: 2px 1px 1px rgba(0, 0, 0, 0.5);
    }
    .content-rightText p{
        padding: 12px 0 8px;
        margin: 0;
    }
    /*Image*/
    .logo-banners1{
        max-width: 100%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
		max-height: 58px;
    }

    /*Second Bannder*/
    .wrapBanner-2{
        background: url(http://d2qcctj8epnr7y.cloudfront.net/images/jayson/180x150-1.png) no-repeat scroll;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        margin: auto;
        position: relative;
        height: 150px;
        width: 180px;
        overflow: hidden;
    }
    .bannerType2{
        color: #fff;
        text-decoration: none;
    }
    .bannerType2,.bannerType2:hover,.bannerType2:focus{
        outline: none;
    }

    /*Top banner*/
    .wrap-topBanner{
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        position: relative;
        display: block;
        width: 118px;
        margin: 37px auto 0;
    }
    .wrap-contentTop{
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        font-size: 20px;
        letter-spacing: 0.01em;
        line-height: 1.1em;
        text-align: center;
        text-shadow: 2px 1px 1px rgba(0, 0, 0, 0.5);
        text-align: center;
    }
    .wrap-contentTop p{
        margin: 0;
    }
    .wrap-contentTop span{
        display: block;
    }

    /*Down banner*/
    .wrap-downBanner{
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        display: block;
        height: 37px;
        margin: 5px 0 0;
        overflow: hidden;
    }
    .wrap-contentDown{
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        width: 125px;
        height: 35px;
        margin: auto;
		padding: 1px 0;
    }
    .wrap-contentDown img{
        max-width: 100%;
		max-height: 32px;
		text-align:center;
    }
    .wrap-contentDown p{
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        display: block;
        margin: 0;
        color: #0088CC;
    }
    .wrap-ad{
        margin-bottom: 25px;
    }
</style>
<div class="container-fluid lead-reset-padd"  style="background: url(<?echo $base_url?>img/bg-socialholdings.jpg) repeat;">
    <div class="row-fluid">
        <div class="wrap-ad" style="background: none repeat scroll 0 0 rgba(255, 255, 255, 0.8);">
            <div class="container overflow-ad">
                <div class="row-fluid">
                    <div style="position:relative;">
                        <div class="animated rotateIn r-d badge-postn">
                            <a href="<?=$domain_affiliate_link;?>" target="_blank" alt="Contrib">
                                <img src="http://d2qcctj8epnr7y.cloudfront.net/images/2013/badge-contrib-3.png">
                            </a>
                        </div>
                    </div>
                    <div class="content-ad" style="text-align: justify;">
                        <div class="text-center">
                          <? if($info['logo']!=''){ ?>
								<a href="http://<?=$info['domain']?>"><img src="<?=$info['logo']?>" alt="<?=$info['title']?>" title="<?=$info['domain']?>" style="max-width:500px" border="0" /></a>
							<? }else{ ?>
								<h1><?=ucwords($info['domain'])?></h1>
							<? } ?>
                            <h4>Learn more about Joining our Partner Network</h4>
                        </div>
                        <a name="top"></a>




                        <div class="padd-banner">
                            <iframe src="http://referrals.contrib.com/aff_index.php?affiliate=<?=$info['domain']?>" width="800px" height="800px" scrolling="auto" frameborder="0" seamless></iframe>
                            <br>
                            <h3 class="banner-header">Get <?=ucwords($info['domain'])?> Banners and Make Money</h3>
                            <div class="banner-main">
                                <dl class="dl-horizontal banner-info">
                                    <dt>Marketing Group</dt><dd>Contrib</dd>
                                    <dt>Banner Size</dt><dd>150 x 150</dd>
                                    <dt>Banner Description</dt><dd>Proud member of Contrib Sticker</dd>
                                    <dt>Target URL</dt><dd>http://www.contrib.com</dd>
                                </dl>
                                <div class="tossing text-center banner-img-cont">
                                    <img src="http://referrals.contrib.com/banners/badge-contrib-2.png" />
                                </div>
                                <p class="text-center banner-source">Source Code - Copy/Paste Into Your Website</p>
                                <textarea class="form-control" rows="3" onclick="this.focus();this.select()" readonly="readonly">
                                    <a href="<?echo $domain_affiliate_link?>" target="_blank"><img style="border:0px" src="http://referrals.contrib.com/banners/badge-contrib-2.png" width="150" height="150" alt="Proud Member of Contrib" /></a>
                                </textarea>

                            </div>
                            <div class="banner-main">
                                <dl class="dl-horizontal banner-info">
                                    <dt>Marketing Group</dt><dd>Contrib</dd>
                                    <dt>Banner Size</dt><dd>150 x 150</dd>
                                    <dt>Banner Description</dt><dd>Contrib Sticker 1</dd>
                                    <dt>Target URL</dt><dd>http://www.contrib.com</dd>
                                </dl>

                                <div class="tossing text-center banner-img-cont">
                                    <img src="http://referrals.contrib.com/banners/badge-contrib-3.png" />
                                </div>

                                <p class="text-center banner-source">Source Code - Copy/Paste Into Your Website</p>
                                <textarea class="form-control" rows="3" onclick="this.focus();this.select()" readonly="readonly">
                                    <a href="<?echo $domain_affiliate_link?>" target="_blank"><img style="border:0px" src="http://referrals.contrib.com/banners/badge-contrib-3.png" width="150" height="150" alt="Contrib"></a>
                                </textarea>
                            </div>
                            <div class="banner-main">
                                <dl class="dl-horizontal banner-info">
                                    <dt>Marketing Group</dt><dd>Contrib</dd>
                                    <dt>Banner Size</dt><dd>150 x 150</dd>
                                    <dt>Banner Description</dt><dd>I love Contrib Sticker</dd>
                                    <dt>Target URL</dt><dd>http://www.contrib.com</dd>
                                </dl>

                                <div class="tossing text-center banner-img-cont">
                                    <img src="http://referrals.contrib.com/banners/badge-contrib-heart5.png" />
                                </div>

                                <p class="text-center banner-source">Source Code - Copy/Paste Into Your Website</p>
                                <textarea class="form-control" rows="3" onclick="this.focus();this.select()" readonly="readonly">
                                    <a href="<?echo $domain_affiliate_link?>" target="_blank"><img style="border:0px" src="http://referrals.contrib.com/banners/badge-contrib-heart5.png" width="150" height="150" alt="I love Contrib"></a>
                                </textarea>
                            </div>
                            <div class="banner-main">
                                <dl class="dl-horizontal banner-info">
                                    <dt>Marketing Group</dt><dd>Contrib</dd>
                                    <dt>Banner Size</dt><dd>200 x 200</dd>
                                    <dt>Banner Description</dt><dd>Contrib Banner</dd>
                                    <dt>Target URL</dt><dd>http://www.contrib.com</dd>
                                </dl>

                                <div class="floating text-center banner-img-cont">
                                    <img src="http://referrals.contrib.com/banners/ban-contrib-200x200-4.png" />
                                </div>

                                <p class="text-center banner-source">Source Code - Copy/Paste Into Your Website</p>
                                <textarea class="form-control" rows="3" onclick="this.focus();this.select()" readonly="readonly">
                                    <a href="<?echo $domain_affiliate_link?>" target="_blank"><img style="border:0px" src="http://referrals.contrib.com/banners/ban-contrib-200x200-4.png" width="200" height="200" alt="Proud Member of Contrib"></a>
                                </textarea>
                            </div>
                            <div class="banner-main">
                                <dl class="dl-horizontal banner-info">
                                    <dt>Marketing Group</dt><dd>Contrib</dd>
                                    <dt>Banner Size</dt><dd>228 x 90</dd>
                                    <dt>Banner Description</dt><dd>Contrib Banner</dd>
                                    <dt>Target URL</dt><dd>http://www.contrib.com</dd>
                                </dl>

                                <div class="floating text-center banner-img-cont">
                                    <img src="http://referrals.contrib.com/banners/ban-contrib-228x90-4.png" />
                                </div>

                                <p class="text-center banner-source">Source Code - Copy/Paste Into Your Website</p>
                                <textarea class="form-control" rows="3" onclick="this.focus();this.select()" readonly="readonly">
                                    <a href="http://referrals.contrib.com/idevaffiliate.php?id=1874_0_1_12" target="_blank"><img style="border:0px" src="http://referrals.contrib.com/banners/ban-contrib-228x90-4.png" width="228" height="90" alt="Proud Member of Contrib"></a>
                                </textarea>
                            </div>
                            <div class="banner-main">
                                <dl class="dl-horizontal banner-info">
                                    <dt>Marketing Group</dt><dd>Contrib</dd>
                                    <dt>Banner Size</dt><dd>728 x 90</dd>
                                    <dt>Banner Description</dt><dd><?echo ucfirst($info['domain'])?> Banner</dd>
                                    <dt>Target URL</dt><dd>http://<?echo $info['domain']?></dd>
                                </dl>

                                <div class="floating text-center banner-img-cont">
                                    <div class="wrap-allbanner">
                                        <div class="wrap-bannerLeft">
                                            <p href="" class="aBnnrP ellipsis" style="<!--display:none;-->">
                                                <!--wellnesschallenge.com-->
                                                <img class="logo-banners1" src="<?echo $info['logo']?>" alt="<?echo $info['domain']?>">
                                            </p>
                                        </div>
                                        <div class="wrap-bannerRight ">
                                            <div class="content-rightText ">
                                                <span class="">Follow , Join and</span>
                                                <p class="ellipsis">Partner with Contrib.com</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <p class="text-center banner-source">Source Code - Copy/Paste Into Your Website</p>
                                <textarea class="form-control" rows="3" onclick="this.focus();this.select()" readonly="readonly">
                                    <script type="text/javascript" src="http://www.contrib.com/widgets/leadbanner/<?echo $info['domain']?>/<?echo $info['domainid']?>"></script>
                                </textarea>
                            </div>
                            <div class="banner-main">
                                <dl class="dl-horizontal banner-info">
                                    <dt>Marketing Group</dt><dd>Contrib</dd>
                                    <dt>Banner Size</dt><dd>180 x 150</dd>
                                    <dt>Banner Description</dt><dd><?echo ucfirst($info['domain'])?> Banner</dd>
                                    <dt>Target URL</dt><dd>http://<?echo $info['domain']?></dd>
                                </dl>

                                <div class="floating text-center banner-img-cont">
                                    <div class="wrapBanner-2">
                                        <div class="wrap-topBanner ">
                                            <div class="wrap-contentTop">
                                                <span>Follow, Join</span>
                                                <span>and Partner with</span>
                                            </div>
                                        </div>
                                        <div class="wrap-downBanner">
                                            <div class="wrap-contentDown">
                                                <p href="" class="ellipsis">
                                                    <img src="<?echo $info['logo']?>" alt="<?echo $info['domain']?>">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <p class="text-center banner-source">Source Code - Copy/Paste Into Your Website</p>
                                <textarea class="form-control" rows="3" onclick="this.focus();this.select()" readonly="readonly">
                                    <script type="text/javascript" src="http://www.contrib.com/widgets/roundleadbanner/<?echo $info['domain']?>/<?echo $info['domainid']?>"></script>
                                </textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--3rd section-->