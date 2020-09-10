<?php

$filname = $_REQUEST['file'];
$currentdir=getcwd();
//echo "<br>Current Diretory=" .$currentdir;
$curdir =  str_replace("adminvi","",$currentdir);
$path =  "../uploadfilingfiles/".$filname;
// header('Content-disposition: attachment; filename='.$filname);
// header('Content-type: application/pdf');
// readfile("../../uploadfilingfiles/".$filname);
 
 if (!is_file($path)) {
    echo 'File not found.('.$path.')';
} elseif (is_dir($path)) {
    echo 'Cannot download folder.';
} else {
    send_download($path);
}
 return;
 header("Location: {$_SERVER['HTTP_REFERER']}");
exit();
 
 function send_download($file) {
    $basename = basename($file);
    $length   = sprintf("%u", filesize($file));

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $basename . '"');
    header('Content-Transfer-Encoding: binary');
    header('Connection: Keep-Alive');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . $length);

    set_time_limit(0);
    readfile($file);
}
?>
