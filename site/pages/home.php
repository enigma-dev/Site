<?php
include_once('/var/www/html/enigma-dev.org/forums/SSI.php');
$page->headextra .= '<link rel="alternate" type="application/rss+xml" href="http://feeds.feedburner.com/enigmanews" title="ENIGMA News">';
$page->addBodyClass('home');
$page->setMetaDescription('ENIGMA Development Environment -- A very high level language, compiled into a less high level language.');
?>
<div style="clear:both"></div>
<div class="right" style="margin-left: 10px">
	<script type="text/javascript">
	<!--
	google_ad_client = "pub-9185210906751858";
	/* Really vertical this time */
	google_ad_slot = "9966185366";
	google_ad_width = 160;
	google_ad_height = 600;
	//-->
	</script>
	<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
</div>

<h2>Welcome</h2>

<p>ENIGMA is a <strong>free</strong> development environment geared towards game development.</p>

<p>
<img src="/site/images/v4/money.png" alt="*" />  It's free and open source!<br />
<img src="/site/images/v4/lightning.png" alt="*" /> Compiled for maximum speed, with lightning fast calculations!<br />
<img src="/site/images/v4/monkey.png" alt="*" /> Easy to learn, and Game Maker compatible!<br />
<img src="/site/images/v4/bricks.png" alt="*" /> It's a great way to get started with C++.<br />
</p>
<p>
<!-- Social media -->
Follow us on Facebook and Twitter!
<br>
    <a href="https://www.facebook.com/pages/ENIGMA-Development-Environment/427268784026069?ref=stream"><img width="40" height="40" src="http://enigma-dev.org/docs/wiki/images/5/55/Facebook.png" alt="Like us on facebook!" /></a>
    <a href="https://twitter.com/EnigmaGamedev"><img width="40" height="40" src="http://enigma-dev.org/docs/wiki/images/f/f7/Twitter.png" alt="Follow us on twitter!" /></a>
</p>

<h2>News</h2>

<?php					
	if (function_exists('ssi_boardNews'))
	{
		$array = ssi_boardNews(1.0, 5, null, 400, 'array');

		foreach ($array as $news)
		{
			echo '
<article class="news">
	<h3><a href="', $news['href'], '">', $news['subject'], '</a></h3>
	<footer>
		By ', $news['poster']['link'], ' | Posted ', $news['time'], '<div style="float: right"></div><br /><br />
	</footer>
	<p>', $news['body'], '</p>
</article>';
		}
	}
	else
	{
		echo 'Something\'s wrong with the forums or database...';
	}
?>

<div class="clear"></div>
