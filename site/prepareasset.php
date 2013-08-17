<?php
// Written by Richard Z.H. Wang (c) 2011, MIT licensed

// Uh, have we set a path in the first place?
if (!isset($_GET['uri']))
{
	header("HTTP/1.1 400 Bad Request");
	echo 'URI not set';
	exit();
}

// Yes? Since we're in the /site/ folder, make the path in the folder below it
$path = '../' . trim($_GET['uri']);

// SCSS is a special case
$parse_as = '';
if (substr($path, -9) == '.scss.css')
{
	$parse_as = 'scss';
	$path = substr($path, 0, -4);
}

// Anyway...
$path_parts = pathinfo($path);
$extension = $path_parts['extension'];

// Does the path exist, is it inside the public_html directory, and is it a CSS or JavaScript file?
$docroot = realpath('../');
if ( !strstr(realpath($path), $docroot) || !($extension == 'css' || $extension == 'scss' || $extension == 'js') )
{
	header("HTTP/1.1 403 Forbidden");
	echo 'Illegal path';
	echo "<br />Path: $path";
	print "<br />Real path: ".realpath($path);
	
	exit();
}

// The gzip magic begins here...
if (extension_loaded('zlib'))
{
	ob_start('ob_gzhandler');
}

switch ($extension)
{
	case 'css': case 'scss': $mime = 'text/css'; break;
	case 'js': $mime = 'text/javascript'; break;
	default: $mime = 'text/plain'; break;
}

header("Content-type: $mime; charset: UTF-8");
header("Cache-Control: must-revalidate");
$offset = 60 * 60 * 24 * 30 * 6; // 180 days
header("Expires: " . gmdate ("D, d M Y H:i:s", time() + $offset) . " GMT");

if ($parse_as == 'scss')
{
	$input_path = realpath($path);
	$output_path = realpath($path).'.css';
	if (!file_exists($output_path))
	{
		exec('sass '.escapeshellarg($input_path).' '.escapeshellarg($output_path));
	}
	else
	{
		if (time() > filemtime($output_path))
		{
			exec('sass '.escapeshellarg($input_path).' '.escapeshellarg($output_path));
		}
	}
	$path = $output_path;
}

echo file_get_contents($path);

// The gzip magic ends here... :(
if (extension_loaded('zlib'))
{
	ob_end_flush();
}
?>
