<?php
if (!defined('SMF'))
{
	include_once('/var/www/html/enigma-dev.org/forums/SSI.php');
}

class ENIGMASiteHelpers
{
	private static function thisdir()
	{
		return dirname(__FILE__);
	}
	
	public static function currentCommit() {
		include_once('dbcreds.php');
		$dbh = mysql_connect("localhost",$dbuser,$dbpass);
		mysql_select_db("irc",$dbh);
		$q = mysql_query("SELECT * FROM commits ORDER BY ID DESC LIMIT 1",$dbh);
		print mysql_error();
		$row = mysql_fetch_assoc($q);
		mysql_close($dbh);
		$ts = $row["ts"];
		$url = $row["url"];
		$repo = $row["repo"];
		$name = $row["name"];
		$msg = $row["message"];
		$mArr = explode("\n",$msg);
		$msg = $mArr[0];
		return "Commit to <span class='red bold'>$repo</span> by <span class='orange'>$name</span>: \"<span class='blue'>$msg\"</span> (at $ts; <a href='$url'>Click here to view</a>.)";
	}
		
	public static function menu()
	{
		include(self::thisdir().'/menu.php');
	}
	
	public static function rand_csv($text)
	{
		$g = explode(",",$text);
		return $g[array_rand($g)];
	}
        
	public static function get_saying()
	{
		$a = file(self::thisdir().'/sayings.txt');
		$s = $a[array_rand($a)];
		
		$s = preg_replace("~%r\((\d+),(\d+)\)~ie","rand($1,$2)", $s);
		$s = preg_replace("~%s\((.*?)\)~ie","ENIGMASiteHelpers::rand_csv(\"$1\")", $s);
		
		return $s;
	}
	
	public static function saying()
	{
		echo self::get_saying();
	}
	
	public static function get_user_info()
	{	
		global $context;
		
		$ret = '';
		
		if (!$context['user']['is_guest'])
		{
			$unreadpms = $context['user']['unread_messages'];
			$readpms = $context['user']['messages'];
			
			$ret = '
			<img src="/site/images/user.png" alt="Logged in as" />
			<span>
				<a href="/forums/index.php?action=profile">' . $context['user']['name'] . '</a>
				<a class="small" href="/forums/index.php?action=logout;sesc=' . $context['session_id'] . '">(logout)</a>
			</span>
			
			<img src="/site/images/pms.png" alt="Private messages:" />
			<span>
				<a href="/forums/index.php?action=pm">
					<span id="newmsgs" style="' . ($unreadpms > 0 ? 'background-color:#f15a5a;padding:4px;' : '') . '">
						' . $unreadpms . '/' . $readpms . '
					</span>' .
						($unreadpms > 0 ? str_replace(array("\n","\r","\r\n", "\t"),'',
							'<script>
								var msgbg = document.getElementById("newmsgs");
								var msgbgtoggle = true;
								setInterval(function() {
									if (msgbgtoggle)
									{
										msgbg.style.backgroundColor = "#ffacac";
										msgbgtoggle = false;
									}
									else
									{
										msgbg.style.backgroundColor = "#f15a5a";
										msgbgtoggle = true;
									}
								}, 1000);
							</script>'
						) : '') . '
				</a>
			</span>';
		}
		else
		{
			$ret = '
			<img src="/site/images/user.png" alt="" />
			<span>Guest | <a href="/forums/index.php?action=login">login</a> | <a href="/forums/index.php?action=register">register</a></span>';
		}
		
		return $ret;
	}
	
	public static function user_info()
	{
		echo self::get_user_info();
	}
	
}

?>
