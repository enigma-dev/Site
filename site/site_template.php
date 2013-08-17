<?php

class ENIGMASite {

public static function output_header($page_title = "No one bothered to name this page!", $head = "", $body_classes = "", $allstyles = true, $bannerlink = "/") {

echo '
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<title>';
echo $page_title;
echo '</title>
	
	<link rel="shortcut icon" href="/site/favicon.ico" type="image/x-icon">
	';

if ($allstyles)
  echo '
	<link rel="stylesheet" type="text/css" href="/site/reset.css">
	<link rel="stylesheet" type="text/css" href="/site/style4.scss.css">';	
echo '
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	 <script src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
	<script src="/site/jquery.marquee.js"></script>
	<script src="/site/knob.js"></script>
	<script src="/site/html5.js"></script>
	<script src="/site/raphael.js"></script>
	<link rel="stylesheet" type="text/css" href="/site/kK.css">
	<script>window.jQuery || document.write(\'<script src="/site/jquery-1.4.2.min.js">\x3C/script>\')</script>
	
	<meta name="google-site-verification" content="wnDSokcqwcmOggWme6de8xnHWcp-qVJ622zQf4FLw3E">
	
	<style type="text/css">
	.red {
		color: #ff0000;
	}
	.bold {
		font-weight: bold;
	}
	.orange {
		color: orange;
	}
	.blue {
		color: blue;
	}

	</style>
	';
	echo $head;
	echo '
</head>

<body class="';
echo $body_classes;
echo'">
<!--This comment should appear on all non-wiki pages of this website-->
	<div id="wrap">
		<div id="header">
			<div class="top">
				<h1><a href="' . $bannerlink . '">ENIGMA Development Environment</a></h1>
			</div>
			<div id="menu-wrap">
				';
 
// Gary hack: chdir("/var/www/html/enigma-dev.org/tracker-old");
// include("../forums/Themes/enigma_v4/nav.php"); 


// Write the navbar
$navitems = array("Home" => "", "About" => "about.htm", "Download" => "download.htm", "Wiki" => "docs/wiki/", "Forums" => "forums/",
                  "EDC" => "edc/", "Games" => "edc/games.php?action=list", "Tracker" => "tracker/", "Progress" => "progress.htm");

echo '<div id="menu"><ul>';
foreach ($navitems as $pg => $pgurl) {
  echo '<li><a href="/' . $pgurl . '">' . $pg . '</a></li> ';
}
echo '</ul></div>';

echo '

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(["_setAccount", "UA-20275772-1"]);
  _gaq.push(["_trackPageview"]);

  (function() {
    var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
    ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
    var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

';


// Write the user info div
echo '<div id="userinfo">';
ENIGMASiteHelpers::user_info();
echo '</div>';

// Write the ENIGMA ticker
echo '<div id="enigmaTicker">
<marquee id="commitTicker" behavior="scroll" scrollamount="2" direction="left">'.ENIGMASiteHelpers::currentCommit().'</marquee>
</div>';

echo '
			</div>
		</div>
		
		<div id="content">
			';
}

public static function output_footer() {
echo '
		</div>
		
		<footer id="footer">
			<div id="footer-copyright">
				&copy;2007-2012 The ENIGMA team ' . /* (is_null($extra) ? '' : $extra) . */ '<br />
				ENIGMA - '; ENIGMASiteHelpers::saying(); echo '
			</div>
			<div class="clear"></div>
		</footer>
	</div>
</body>
<script type="text/javascript" src="/site/ticker.js"></script>
</html>
';

}


}
