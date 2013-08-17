<?php
require_once("site_template.php");

ENIGMASite::output_header($this->getTitle(), $this->getHeadHTML(), $this->getBodyClasses());
$this->outputContent();
ENIGMASite::output_footer();
?>
