<?php
// By a2h

$resfolder = 'site';
$sitename = 'ENIGMA Development Environment';
$page = new PageBuilder();
register_shutdown_function(array($page, 'finish'));

class PageBuilder
{
	public $headextra='';
	private $title, $content, $stylesheets=array(), $javascripts=array(), $bodypre, $disabled=false, $sitename, $location;
	
	function PageBuilder()
	{
		global $sitename, $location, $resfolder;
		
		// outside stuff
		$this->sitename = $sitename;
		$this->location = $location;
		
		// meta
		$this->metadescription = '';
		
		$this->bodyClasses = array();
		
		// start capturing the content
		ob_start();
	}
	
	public function theme_disable($do)
	{
		$this->disabled = $do;
	}
	
	function setTitle($title)
	{
		global $sitename;
		$this->title = $title;
	}
	
	function setMetaDescription($d)
	{
		$this->metadescription = $d;
	}
	
	function setType($type)
	{
		$this->type = $type;
	}
	
	function addCSS($path)
	{
		$this->stylesheets[] = $path;
	}
	
	function addJS($path)
	{
		$this->javascripts[] = $path;
	}
	
	public function addBodyClass($class)
	{
		$this->bodyClasses[] = $class;
	}
	
	public function getBodyClasses()
	{
		$res = '';
		$c = count($this->bodyClasses);
		for ($i=0; $i<$c; $i++)
		{
			if ($i > 0)
			{
				echo ' ';
			}
			$res .= $this->bodyClasses[$i];
		}
		return $res;
	}
	public function outputBodyClasses()
	{
		echo $this->getBodyClasses();
	}
	
	public function output_menu()
	{
		global $siteroot;
		include($siteroot . '/site/menu.php');
	}
	
	function getTitle()
	{
		return $this->sitename . ' &raquo; ' . $this->title;
	}
	function outputTitle()
	{
		echo $this->getTitle();
	}
	
	function getHeadHTML()
	{
		$res = '';
		
		if ($this->metadescription != '')
		{
			$res .= "\t" . '<meta name="description" content="' . $this->metadescription . '" />' . "\n";
		}
		
		// $res .= $this->headextra;
		return $res;
	}
	function outputHeadHTML()
	{
		echo $this->getHeadHTML();
	}
	
	function outputContent()
	{
		echo $this->content;
	}
	
	function outputSidebar()
	{
		/* */
	}
	
	public function finish()
	{
		global $config;
		
		// Stop capturing all that lovely content
		$this->content = ob_get_clean();		
		
		// Don't want the overall stuff? All coo' :D
		if ($this->disabled)
		{
			echo $this->content;
			return true;
		}
		
		// Alright, the overall template can handle the content...
		ob_start();
		include("overall.php");
		$out = ob_get_clean();
		
		// To ensure nothing at all is run (at least, most stuff) after debug info, we stick it at the end :O
		if (!empty($debug) && $debug)
		{
			$out = str_replace('</body>', $this->build_debug() . '</body>', $out);
		}
		
		echo $out;
	}
}
?>
