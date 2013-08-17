<div class="WikiText">
  <h1><a href="/docs/Wiki/Install">Download</a></h1>
  <p>
    <i style="text-style: italics">This page is included from the Wiki. 
       If it doesn't read like a typical downloads page, that's largely
       because it isn't. We still haven't coordinated a formal release
       mechanism: read on for more information.</i>
  </p>
<?php
// comment these lines out for production use
$fErrLevel = 0;
error_reporting($fErrLevel);
ini_set('display_errors', 0);
 
// ++++ CONFIGURATION PART 1
$wpWiki = '/../../docs/wiki';
$wpSkins = "$wpWiki/skins";
$strTitleBase = 'ENIGMA Development Environment';
 
$arCSS = array(
  'wikiAgree.css' => 'screen',
  //$wpSkins.'/vector/main-ltr.css' => 'screen',
  //$wpSkins.'/common/shared.css' => 'screen',
  //$wpSkins.'/common/commonPrint.css' => 'print'
  );
// ---- CONFIGURATION PART 1
 
$preIP = dirname( __FILE__ ).$wpWiki;
//$preIP = dirname( '../index.html' ).'/wiki';
chdir($preIP);
require_once( "$preIP/includes/WebStart.php" );
 
# Initialize MediaWiki base class
require_once( "$preIP/includes/Wiki.php" );
$mediaWiki = new MediaWiki();
OutputPage::setEncodings(); # Not really used yet

// ++++ CONFIGURATION PART 2
$wpPage = 'Install';
// ---- CONFIGURATION PART 2
 
$wgTitle = $mediaWiki->checkInitialQueries( $wpPage, 'view' );
 
// load $wgArticle
$wgArticle = MediaWiki::articleFromTitle( $wgTitle );
//$wgArticle = $mediaWiki->initialize ( $wgTitle, $wgOut, $wgUser, $wgRequest );
//$mediaWiki->performRequestForTitle( $wgTitle, $wgArticle, $wgOut, $wgUser, $wgRequest );
 
// create appropriate title string
$strPageName = $wgTitle->getText();
$strTitlePage = substr($strPageName,strrpos($strPageName,'/')+1);
if (empty($strTitlePage)) {
    $strTitle = $strTitleBase;
} else {
    $strTitle = $strTitlePage.' - '.$strTitleBase;
}
//$out = $wgParser->recursiveTagParse($txtPage);
 
if (is_object($wgArticle)) {
    // fetch the page contents and parse it
    require_once( "$preIP/includes/Article.php" );
    global $wgParser;
    $txtPage = $wgArticle->getContent();
    $objOptions = new ParserOptions();
    $objPOut = $wgParser->parse( $txtPage, $wgTitle, $objOptions );
    $out = $objPOut->getText();
} else {
    $out = "could not load page from database";
}
 
$htHdr = '';
foreach ($arCSS as $fs => $medium) {
    $htHdr .= "\n".'<link rel="stylesheet" href="'.$fs.'" media="'.$medium.'" />';
}
 
echo <<<__END__
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" dir="ltr">
<head>
<title>$strTitle</title>$htHdr
</head>
<body class="mediawiki ltr ns-0 ns-subject page-Whiteboard skin-vector">
<div>
__END__;
 
 
echo $out;
 
echo '</div></body></html>';
?>
</div>
