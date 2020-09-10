<?php

$up_maritalStatus = array( 0 => 'no answer', 1 => 'single', 2 => 'married', 3 => 'committed', 4 => 'open marriage', 5 => 'open relationship' );

$up_occupation = array( 0 => 'no answer', 1 => 'Student', 2 => 'Working', 3 => 'Not working');

$up_humorLeval = array( 0 => 'no answer', 1 => 'High', 2 => 'Average', 3 => 'Low');

$up_temperLeval = array( 0 => 'no answer', 1 => 'High', 2 => 'Average', 3 => 'Low');

$up_complexation = array( 0 => 'no answer', 1 => 'Very fair', 2 => 'Fair', 3 => 'Average',  4 => 'Wheatish', 5 => 'Brown' );

$um_fashion = array( 0 => 'No', 1 => 'Yes', 2 => 'Maybe' );

$um_drink = array( 0 => 'No', 1 => 'Yes', 2 => 'Ocasionally' );

$um_frank = array( 0 => 'Life is boring yaar', 1 => 'Life is very exiting yaar', 2 => 'I need interesting things to happen', 3 => 'I really need to get out and get some fresh air');

$um_freeTime = array( 0 => 'Reading a book ', 1 => 'Watching a movie ', 2 => 'Go shopping ', 3 => 'Calling up a friend ', 4 => 'Play a game ', 5 => 'Roaming about' );

$um_cartoons = array( 0 => 'Mickey', 1 => 'Mini', 2 => 'Goofy ', 3 => 'Donald',  4 => 'Tom', 5 => 'Jerry', 6 => 'Popeye', 7 => 'Jhony quest', 8 => 'Jhonney Bravo',  9 => 'power puff girls', 10 => 'Spidy', 11 => 'All', 12 => 'Sorry - am not so much towards cartoons' );

$uv_threeThings = array( 0 => 'Sensitive , Good looking , Intelligent', 1 => 'Good looking , Intelligent, Humor', 2 => 'Intelligent , Humor , Style', 3 => 'Humor , Style , wealth', 4=> 'Style , wealth , human nature');

$uv_Hmustach = array( 0 => 'No', 1 => 'Yes', 2 => 'slightly' ); $uv_Hbeard = $uv_Hmustach;

$uv_Hbody = array( 0 => 'Slim body', 1 => 'Atheletic body', 2 => 'Average body', 3 => 'Gym body' );

$uv_IQ = array( 0 => 'Very Intelligent', 1 => 'Intelligent', 2 => 'Average' );

$uv_lookFeel = array( 0 => 'Rugged', 1 => 'Neat', 2 => 'Casual' );

$uv_hairStyle = array( 0 => 'Dosent matter', 1 => 'Silky', 2 => 'curly', 3 => 'Long');

$uv_humorLeval = array( 0 => 'Average', 1 => 'High', 2 => 'Low');

$uv_complexation = array( 0 => 'Dosent matter', 1 => 'Very fair', 2 => 'Fair', 3 => 'Average',  4 => 'Wheatish', 5 => 'Brown' );

$uv_eyes  = array( 0 => 'Black', 1 => 'Brown', 2 => 'Blue', 3 => 'Wear a neat specs');

$uv_alwaysBe = array( 0 => 'with a gang of boys', 1 => 'with a gang of girls', 2 =>'alone', 3 => 'with a gang of both boys and girls');

$uv_F_usualWear = array( 0 => 'Chudithar', 1 => 'Saree', 2 => 'Jean wear', 3 => 'skirt wear', 4 => 'salwar kameez', 5 => 'Spaghetti straps', 6 => 'Halter dresses' );

$uv_M_usualWear = array( 7 => 'Jean-tShirt', 8 => 'formal wear', 9 => 'casual wear', 10 => 'dothi-shirt', 11 => 'trouser-tShirt', 12 => '3/4ths-tshir');

$uv_usualWear = array_merge($uv_F_usualWear, $uv_M_usualWear);

$uv_F_loveWear = array( 0 => 'Chudithar', 1 => 'Saree', 2 => 'Jean wear', 3 => 'skirt wear', 4 => 'salwar kameez', 5 => 'Spaghetti straps', 6 => 'Halter dresses', 13 => 'Same');

$uv_M_loveWear = array( 7 => 'Jean-tShirt', 8 => 'formal wear', 9 => 'casual wear', 10 => 'dothi-shirt', 11 => 'trouser-tShirt', 12 => '3/4ths-tshir', 14 => 'Nothing');

$uv_loveWear = array_merge($uv_F_loveWear, $uv_M_loveWear);

$uv_F_friends = array( 0 => 'Yup I have', 1 => 'would love to have', 2 => 'have friends who are boys', 4 => 'naaay - leave me alone', 5 => 'not intrested - OK !', 6 => 'will think of it later' );

$uv_M_friends = array( 0 => 'Yup I have', 1 => 'would love to have', 3 => ' have friends who are girls', 4 => 'naaay - leave me alone', 5 => 'not intrested - OK !', 6 => 'will think of it later' );

$uv_friends = array_merge($uv_F_friends, $uv_F_friends);

$uv_F_Ishout = array( 0 => 'Why should boys have all the fun !', 1 => 'I wish am reborn as a boy !', 2 => 'Am so happy am a girl, wish to be reborn as a girl', 4 => 'I bet boys don\'t have so much fun as girls have' );

$uv_M_Ishout = array( 5 => 'Why was I born sooo handsome !', 6 => 'I wish am reborn as a girl !', 7 => 'Am so happy am a boy, wish to be reborn as a boy', 8 => 'I bet girls don\'t have so much fun as boys have', 9 => 'Why isnt any girl looking at me !!!', 10 =>'What else does girls want from meeee !!!' );

$uv_Ishout = array_merge($uv_F_Ishout, $uv_M_Ishout);

// Arrays of Labels
$user_personal_labels = array();
$user_personal_labels['up_nickName'] = "People call me";
$user_personal_labels['up_aboutMe'] = "About me";
$user_personal_labels['up_education'] = "Education";
$user_personal_labels['up_height'] = "Height";
$user_personal_labels['up_complexation'] = "Complexsion";
$user_personal_labels['up_maritalStatus'] = "Marital Status";
$user_personal_labels['up_contactEmail'] = "Contact ID";
$user_personal_labels['up_cellNumber'] = "Cell number";
$user_personal_labels['up_address'] = "Address";
$user_personal_labels['up_occupation'] = "Occupation";
$user_personal_labels['up_humorLeval'] = "Humor level";
$user_personal_labels['up_temperLeval'] = "Temper level";
$user_personal_labels['up_Fhero'] = "Favorite hero";
$user_personal_labels['up_Fheroine'] = "Favorite heroine";
$user_personal_labels['up_Ffood'] = "Favorite food items";
$user_personal_labels['up_FsiteUrl'] = "My favorite web site";

$user_mPersonal_labels = array();
$user_mPersonal_labels['um_work'] = "Where do you work";
$user_mPersonal_labels['um_collegeID_FK'] = "College";
$user_mPersonal_labels['um_wantToBe'] = "I wanted to be a";
$user_mPersonal_labels['um_admireWorld'] = "Person I admire world wide";
$user_mPersonal_labels['um_admireIndia'] = "Person I admire in India";
$user_mPersonal_labels['um_admireArea'] = "Person I admire in my area";
$user_mPersonal_labels['um_Fsong'] = "My favorite song";
$user_mPersonal_labels['um_Farea'] = "Area I like the most";
$user_mPersonal_labels['um_fashion'] = "I admire fashion";
$user_mPersonal_labels['um_notLikePersons'] = "I dont like persons who";
$user_mPersonal_labels['um_Fbike'] = "My favorite 2 Wheeler";
$user_mPersonal_labels['um_Fhotel'] = "My favorite hotel in my area";
$user_mPersonal_labels['um_hangOutSpot'] = "My hang out spot in my area";
$user_mPersonal_labels['um_drink'] = "Drink";
$user_mPersonal_labels['um_smoke'] = "Smoke";
$user_mPersonal_labels['um_frank'] = "To be frank";
$user_mPersonal_labels['um_freeTime'] = "In my free time, I would prefer";
$user_mPersonal_labels['um_cartoons'] = "Cartoon character I like most";

$user_vPersonal_labels = array();
$user_vPersonal_labels['uv_threeThings'] = "Three things I see first in a person ";
$user_vPersonal_labels['uv_Hmustach'] = "Have mustach";
$user_vPersonal_labels['uv_Hbeard'] = "Have beard";
$user_vPersonal_labels['uv_Hbody'] = "Should have a";
$user_vPersonal_labels['uv_Hheight'] = "Height should be";
$user_vPersonal_labels['uv_IQ'] = "IQ";
$user_vPersonal_labels['uv_lookFeel'] = "Look & feel";
$user_vPersonal_labels['uv_hairStyle'] = "Hair style";
$user_vPersonal_labels['uv_humorLeval'] = "Humor level";
$user_vPersonal_labels['uv_complexation'] = "Complexsion";
$user_vPersonal_labels['uv_eyes'] = "Eyes";
$user_vPersonal_labels['uv_alwaysBe'] = "Should always be";
$user_vPersonal_labels['uv_noticeInMe'] = "The most attractive thing you will notice in me ";
$user_vPersonal_labels['uv_usualWear'] = "I usually wear";
$user_vPersonal_labels['uv_loveWear'] = "But I would love wearing";
$user_vPersonal_labels['uv_Ishout'] = "One thing I will shout out on top of a mountain ";

$user_vPersonal_labels['uv_friends'] = "Boy friends";  // Female "0" added as default

?>