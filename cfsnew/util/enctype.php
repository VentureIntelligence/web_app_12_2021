<?php
function base64_decodee($str){
		return base64_decode(base64_decode($str));
}
?>