<?php 

function makeScrap($text) {

//$text ="http://www.youtube.com/watch?v=2p9QW4QwJB8";
	if (preg_match_all('/\[img(\:(.+))?( .+)?\]/isU', $text, $matches_code)) {
		
		foreach ($matches_code[0] as $ci => $code) {
			$replacementImg = "<img src=".$matches_code[2][$ci]." style='border:0' border=\"0\"/>";
			$text = str_replace($code, $replacementImg, $text);

		}
	}
	
	if(preg_match_all('/\[(\:(.+))?( .+)?\]/isU',$text,$matches_code)){

		foreach ($matches_code[0] as $ci => $code) {
				
		if($code=="[:c]")
				$replacementImg = "<img style='border:0;float:none;' src='".WEB_IMG_DIR."smiles/i_cool.gif' border=\"0\"/>";
		
		if($code=="[:p]")	
				$replacementImg = "<img style='border:0;float:none;' src='".WEB_IMG_DIR."smiles/i_funny.gif' border=\"0\"/>";
		
		if($code=="[:(]")	
				$replacementImg = "<img style='border:0;float:none;' src='".WEB_IMG_DIR."smiles/i_sad.gif' border=\"0\"/>";
				
		if($code=="[:)]")	
				$replacementImg = "<img style='border:0;float:none;' src='".WEB_IMG_DIR."smiles/i_smile.gif' border=\"0\"/>";
		
		
		if($code=="[:o]")	
				$replacementImg = "<img style='border:0;float:none;' src='".WEB_IMG_DIR."smiles/i_surprise.gif' border=\"0\"/>";
				
		if($code=="[:w]")	
				$replacementImg = "<img style='border:0;float:none;' src='".WEB_IMG_DIR."smiles/i_wink.gif' border=\"0\"/>";
		
			
			$text = str_replace($code, $replacementImg, $text);

		}
	}
	
	
	$text = "[video: ".$text."]";
	if (preg_match_all('/\[mp3(\:(.+))?( .+)?\]/isU', $text, $matches_code)) {
	
		foreach ($matches_code[0] as $ci => $code) {
			$replacementAudio =  audio_player($matches_code[2][$ci]);
			$text = str_replace($code, $replacementAudio, $text);
		}
	}	
		
	if (preg_match_all('/\[video(\:(.+))?( .+)?\]/isU', $text, $matches_code)) {  
		foreach ($matches_code[0] as $ci => $code) {
			$video = array(
				'source'	=> $matches_code[2][$ci],
				'width'		=> 400,
				'height'	=> 400,
				'autoplay'	=> 0,
			);
			// Load all codecs
			$codecs = video_filter_codec_info();

			// Find codec
			foreach ($codecs as $codec) {
				
				if (!is_array($codec['regexp'])) {
					$codec['regexp'] = array($codec['regexp']);
				}
				
				// Try different regular expressions
				foreach ($codec['regexp'] as $delta => $regexp) {
				
					if (preg_match($regexp, $video['source'], $matches)) {
						$video['codec'] = $codec;
						$video['codec']['delta'] = $delta;
						$video['codec']['matches'] = $matches;
						break 2;
					}
				}
			}

			// Codec found
			if ($video['codec']) {
				
				// Override default attributes
				if ($matches_code[3][$ci] && preg_match_all('/\s+([a-z]+)\:([^\s]+)/i', $matches_code[3][$ci], $matches_attributes)) {
	
					foreach ($matches_attributes[0] as $ai => $attribute) {
						$video[$matches_attributes[1][$ai]] = $matches_attributes[2][$ai];
					}
				}
				
				// Pick random out of multiple sources separated by ','
				if (strstr($video['source'], ',')) {
					$sources					= explode(',', $video['source']);
					$random						= array_rand($sources, 1);
					$video['source']	= $sources[$random];
				}

				// Resize within set width and height to given ratio
				if ($video['codec']['ratio']) {
					$video_ratio = $video['width'] / $video['height'];
					
					if ($video['codec']['ratio'] > $video_ratio) {
						$video['height'] = round($video['height'] / $video['codec']['ratio']);
						
					} else {
						$video['width'] = round($video['width'] * $video['codec']['ratio']);;
					}
				}
				
				$video['autoplay'] = (bool) $video['autoplay'];
				$video['align'] = in_array($video['align'], array('left', 'right')) ? $video['align'] : NULL;

				$replacement = $video['codec']['callback']($video);
			
			}
			$text = str_replace($code, $replacement, $text);
		}
	}
  
	return $text;
}

// Settings for Mp3 File 

function audio_player($url) {
	$audioText = '
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/ flash/swflash.cab#version=7,0,0,0"  height="27" width="460">
	<param value="http://www.areapal.com/audio-player.swf" name="movie"/>	
	<param value="noScale" name="scale"/><param name="quality" value="best">
	<param value="opaque" name="wmode"/><param value="TL" name="salign"/>
	<param value="audioUrl='.$url.'" name="FlashVars"/>
	<embed type="application/x-shockwave-flash" 
		src="http://www.areapal.com/audio-player.swf?audioUrl='.$url.'"
		width="460" height="27" quality="best" bgcolor="#ffffff" 
		wmode="window" flashvars="playerMode=embedded" />
</object>';
 
	return $audioText;
}
// Settings of Video file 

function video_filter_flash($video, $params = array()) {
	$output = '';
	
	$output .= '<object type="application/x-shockwave-flash" ';
	
	if ($video['align']) {
		$output .= 'style="float:'.$video['align'].'" ';
	}
	
	$output .= 'width="'.$video['width'].'" height="'.$video['height'].'" data="'.$video['source'].'">'."\n";
	
	$defaults = array(
		'movie' => $video['source'],
		'wmode' => 'transparent',
	);
	
	$params = array_merge($defaults, (is_array($params) && count($params)) ? $params : array());
		
	foreach ($params as $name => $value) {
		$output .= '  <param name="'.$name.'" value="'.$value.'" />'."\n";
	}
	
	$output .= '</object>'."\n";
	
	return $output;	
}



function video_filter_codec_info()
{
	$codecs = array();
	$codecs['youtube'] = array(
		'name' => 'YouTube',
		'callback' => 'video_filter_youtube',
		'regexp' => '/youtube\.com\/watch\?v=([a-z0-9\-_]+)/i',
		'ratio' => 425 / 355,
	);
	$codecs['google'] = array(
		'name' => 'Google Video',
		'callback' => 'video_filter_google',
		'regexp' => '/video\.google\.com\/videoplay\?docid=(\-?[0-9]+)/',
		'ratio' => 400 / 326,
	);
	$codecs['godtube'] = array(
		'name' => 'GodTube',
		'callback' => 'video_filter_godtube',
		'regexp' => '/godtube\.com\/view_video\.php\?viewkey=([a-z0-9]+)/',
		'ratio' => 300 / 270,
	);

	$codecs['metacafe'] = array(
		'name' => 'metacafe',
		'callback' => 'video_filter_metacafe',
		'regexp' => '/metacafe\.com\/watch\(\d+)(.*)/i',
		'ratio' => 300 / 270,
	);
	return $codecs;
}

function video_filter_youtube($video) {
	$video['source'] = 'http://www.youtube.com/v/'.$video['codec']['matches'][1].($video['autoplay'] ? '&autoplay=1' : '');
	return video_filter_flash($video);
}

function video_filter_google($video) {
	$video['source'] = 'http://video.google.com/googleplayer.swf?docId='.$video['codec']['matches'][1];
	
	return video_filter_flash($video);
}

function video_filter_godtube($video) {
	$video['source'] = 'http://www.godtube.com/flvplayer.swf?viewkey='.$video['codec']['matches'][1];
	
	return video_filter_flash($video);
}


function displayVideo($URL) {

	$video = array(
		'source'	=> $URL,
		'width'		=> 400,
		'height'	=> 400,
		'autoplay'	=> 0,
	);
	// Load all codecs
	$codecs = video_filter_codec_info();
			
	foreach ($codecs as $codec) {
		
		if (!is_array($codec['regexp'])) {
			$codec['regexp'] = array($codec['regexp']);
		}
		
		// Try different regular expressions
		foreach ($codec['regexp'] as $delta => $regexp) {
		
			if (preg_match($regexp, $video['source'], $matches)) {
				$video['codec'] = $codec;
				$video['codec']['delta'] = $delta;
				$video['codec']['matches'] = $matches;
				break 2;
			}
		}
	}

	// Codec found
	if ($video['codec']) {	
		
		// Resize within set width and height to given ratio
		if ($video['codec']['ratio']) {
			$video_ratio = $video['width'] / $video['height'];
			
			if ($video['codec']['ratio'] > $video_ratio) {
				$video['height'] = round($video['height'] / $video['codec']['ratio']);
				
			} else {
				$video['width'] = round($video['width'] * $video['codec']['ratio']);;
			}
		}
		
		$video['autoplay'] = (bool) $video['autoplay'];
		$video['align'] = in_array($video['align'], array('left', 'right')) ? $video['align'] : NULL;

		return $video['codec']['callback']($video);
	
	}	
}	
?>