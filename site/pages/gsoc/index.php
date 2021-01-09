<?php

function get_content_from_github($url) {
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json', 'User-Agent: Mozilla/5.0 (Windows NT 6.1)'));
	$content = curl_exec($ch);
	curl_close($ch);
	return $content;
}

include('GSOC_Header.html');

$json = json_decode(get_content_from_github('https://api.github.com/repos/enigma-dev/enigma-dev/issues?labels=GSOC'), true);

#echo 'Last error: ', json_last_error_msg(), PHP_EOL, PHP_EOL;

foreach ($json as $key => $value) {
  echo '<div class="Idea">' . "\n";
    
    echo "\t" . '<div class="IdeaTitle">'  . "\n";
    echo "\t" . $value["title"]  . "\n";
    echo "\t" . '</div>'  . "\n";
    
    echo "\t" . '<div class="IdeaDesc">'  . "\n";
    echo "\t" . $value["body"]  . "\n";
    echo "\t" . '</div>' . "\n";
  
  echo '</div>' . "\n\n";
}

include('GSOC_Footer.html');

?>
