<?php
//////////////////////////
//// MAN THE HARPOONS ////
//////////////////////////

include("site/dbcreds.php");
mysql_connect("localhost",$dbuser,$dbpass);
mysql_select_db("irc");

if (!isset($_POST['payload'])) die('Not a valid hook.');
file_put_contents('payload.txt',$_POST['payload']);
$payload = json_decode($_POST['payload']);
$commits = $payload->{'commits'};
function mrse($a) {
	return mysql_real_escape_string($a);
}
$repo = $payload->{'repository'}->{'name'};
foreach ($commits as $commit) {
	$url = $commit->{"url"};
	$name = mrse($commit->{"author"}->{"name"});
	$email = mrse($commit->{"author"}->{"email"});
	$commit_id = mrse($commit->{'id'});
	$ts = $commit->{"timestamp"};
	$message = mrse($commit->{"message"});
	mysql_query("INSERT INTO commits (url,name,email,ts,message,repo,commit_id) VALUES ('$url','$name','$email','$ts','$message','$repo','$commit_id')");
}

