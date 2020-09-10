<?php
    //Start session 
    session_start();
    //out put chaptcha image type
    header('Content-type: image/jpeg');
    //length you character which has captcha image
    $length = 6;
    // characters want to display in out put 
    $chars = "abcdefghijklmnopqrstuvwxyz123456789";
    $string = "";
    while (strlen($string) < $length) {
    $string .= $chars[mt_rand(0,strlen($chars))];
    }
    //if you use letters and numeric symbols, convert all to  upper case letter is more user friendly
    $string = strtoupper($string);
    //get a random generated sting to PHP session 
    $_SESSION['validation_code'] = $string;
    $im = imagecreate( 225, 50 );
    // if you want to set background image, uncomment below line and put correct image name you have 
    //$im = imagecreatefrompng('images/captcha.png');
    
    //set capthca image background color
    $bg   = imagecolorallocate($im, 255, 255, 255);
    //define colors for string 
    $grey    = imagecolorallocate($im, 128, 128, 128);
    $black    = imagecolorallocate($im, 0, 0, 0);
    $redpen    = imagecolorallocate($im, 255, 0, 0);
    $googlered   = imagecolorallocate($im, 197,18,44);
    $greenpen   = imagecolorallocate($im, 0, 153, 0);
    $greennew  = imagecolorallocate($im, 127, 255, 170);
    $googleblue = imagecolorallocate($im, 65, 103, 220);
    $bluepen   = imagecolorallocate($im, 0, 0, 255);
    $blackpen   = imagecolorallocate($im, 0, 0, 0);
    $yellowpen  = imagecolorallocate($im, 255, 200, 0);
    $aquapen   = imagecolorallocate($im, 0, 255, 255);
    $fuschiapen = imagecolorallocate($im, 255, 0, 255);
    $greypen   = imagecolorallocate($im, 153, 153, 153);
    $silverpen   = imagecolorallocate($im, 204, 204, 204);
    $tealpen   = imagecolorallocate($im, 0, 153, 153);
    $limepen   = imagecolorallocate($im, 0, 255, 0);
    $navypen   = imagecolorallocate($im, 0, 0, 153);
    $purplepen  = imagecolorallocate($im, 153, 0, 153);
    $maroonpen = imagecolorallocate($im, 153, 0, 0);
    $olivepen   = imagecolorallocate($im, 153, 153, 0);
    $textcolor    = imagecolorallocate($grey, $black, $redpen, $googlered, $greenpen, $greennew,
 $googleblue, $bluepen, $blackpen, $yellowpen, $aquapen, $fuschiapen, $greypen, $silverpen, 
$tealpen, $limepen, $navypen, $purplepen, $maroonpen, $olivepen);
    $font = 'fonts/AManExtendedBold.ttf';
    $location_x = 5;
    //randomly gets color for string 
    $font_color = $textcolor[rand(0,19)];
    for($counter=0; $counter < strlen($string) ; $counter++){
        imagettftext($im, 27,0, $location_x, 40, $font_color , $font, substr($string,$counter,1) );
        $location_x = $location_x + 35 ;
    }
            
    imagejpeg($im);
    imagedestroy($im);
    
?>
 