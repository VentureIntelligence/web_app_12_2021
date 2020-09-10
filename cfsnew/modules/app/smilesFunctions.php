<?php 

function makeSmiles($text) {

	//if (preg_match_all('/\[smiles(\:(.+))?( .+)?\]/isU', $text, $matches_code)) {
	if(preg_match_all('/\[(\:(.+))?( .+)?\]/isU',$text,$matches_code)){

		foreach ($matches_code[0] as $ci => $code) {
				
		if($code=="[:)]")
				$replacementImg = "<img style='border:1' src='".WEB_IMG_DIR."/smiles/i_cool.gif' border=\"0\"/>";
		
		if($code=="[:(]")	
				$replacementImg = "<img src='".WEB_IMG_DIR."/smiles/i_funny.gif' border=\"0\"/>";
		
		if($code=="[:{]")	
				$replacementImg = "<img src='".WEB_IMG_DIR."/smiles/i_sad.gif' border=\"0\"/>";
				
		if($code=="[:}]")	
				$replacementImg = "<img src='".WEB_IMG_DIR."/smiles/i_smile.gif' border=\"0\"/>";
		
		
		if($code=="[:s]")	
				$replacementImg = "<img src='".WEB_IMG_DIR."/smiles/i_surprise.gif' border=\"0\"/>";
				
		if($code=="[:w]")	
				$replacementImg = "<img src='".WEB_IMG_DIR."/smiles/i_wink.gif' border=\"0\"/>";
		
		
		
			$text = str_replace($code, $replacementImg, $text);

		}
	}
	
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

	
?>