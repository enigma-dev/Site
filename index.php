<?php
/**
 * ENIGMA Website v4.3
 * 4.3 has resulted in a complete rewrite of the site backend
 * Copyright (c) 2008-2010 Josh @ Dreamland, a2h, MahFreenAmeh
 */

// Blergh
$siteroot = "/var/www/html/enigma-dev.org";

// Functions used across the entire site
include_once('site/functions.php');

// The template handler
include('site/template.php');

// The menu (supposedly). Currently this won't be in use for anything other than page detection. The outputted menu is in menu.php
$pages = array(
	'home' => array(
		'title' => 'Home',
		'file' => 'home.php',
		'url' => '/'
	),
	'about' => array(
		'title' => 'About',
		'file' => 'about.php',
		'url' => '/?p=about'
	),
	'download' => array(
		'title' => 'Download',
		'file' => 'download.php',
		'url' => '/?p=download'
	),
	'forum' => array(
		'title' => 'Forums',
		'url' => '/forums/'
	),
	'tracker' => array(
		'title' => 'Tracker',
		'url' => '/tracker/'
	),
	'progress' => array(
		'title' => 'Progress',
		'file' => 'progress.php',
		'url' => '/?p=progress'
	),
	'todo' => array(
		'in_menu' => false,
		'title' => 'General Todo',
		'file' => 'progress-todo.php',
		'url' => '/?p=todo'
	),
	'functions' => array(
		'in_menu' => false,
		'title' => 'Function Progress',
		'file' => 'progress-functions.php',
		'url' => '/?p=functions'
	),
	'functions-missing' => array(
		'in_menu' => false,
		'title' => 'Missing Functions',
		'file' => 'progress-functions-missing.php',
		'url' => '/?p=functions-missing'
	),
        'desc' => array(
              'in_menu' => false,
              'title' => 'Describin\' stuff.',
              'file' => '../pages-old/desc.php',
              'url' => '/?p=desc'
		  ),
        'batch' => array(
              'in_menu' => false,
              'title' => 'Batch Editor',
              'file' => '../pages-old/batch.php',
              'url' => '/?p=batch')
);

// If we haven't set a page at all, we're at home sweet home
if (!isset($_GET['p']))
{
	$curpage = $pages['home'];
}
// But if we have, and IT EXISTS, then send us over to it.
elseif (array_key_exists($_GET['p'], $pages))
{
	$curpage = $pages[$_GET['p']];
}

// Now include it if we have a page to go to...
if (isset($curpage))
{
	$page->setTitle($curpage['title']);
	$path_resources = 'site/img';
	include('site/pages/' . $curpage['file']);
}
// Otherwise, let scratchy cat take over the stage!
else
{
	// Some redirects we have set up for search engines
	if ($_GET['p'] == 'info')
	{
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: ./about.htm");
		exit();
	}
	
	header("HTTP/1.1 404 Not Found");
	$page->setTitle('404 Page Not Found');
	if (2018 < 1995) {
		echo '
		<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="100%" height="640" id="myfile" align="middle">
		<param name="allowScriptAccess" value="sameDomain" />
		<param name="movie" value="/site/404.swf" />
		<param name="quality" value="high" />
		<param name="bgcolor" value="#ffffff" />
		<embed src="/site/404.swf" quality="high" bgcolor="#000000" width="100%" height="640" name="myfile" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go
		/getflashplayer" />
		</object>';
	} else {
		echo '<div style="width:100%;height:calc(100vh - 150px);background:black;text-align:center"><img src="/site/scratchy-cat.gif" style="object-fit:contain;width:100%;height:100%"></div>';
		echo '<audio autoplay loop><source src="/site/404.ogg" type="audio/ogg"/><source src="/site/404.mp3" type="audio/mpeg"/><source src="/site/404.wav" type="audio/wav"/>Welcome to 2018, my friend. :)</audio>';
	}
}
?>
