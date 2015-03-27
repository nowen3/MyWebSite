<?php
require 'code/ImageManipulator.php';
require 'code/functions.php';
require'includes/header.html';
require'includes/navbar1.html';

$action = 'index';
$disallow_paths = array('header', 'footer');

if (!empty($_GET['page']))  {
    $tmp_action = basename($_GET['page']);
    if (!in_array($tmp_action, $disallow_paths) && file_exists("includes/{$tmp_action}.html"))
    {
	  $action = $tmp_action;
    } else
    {
	    $action = 'notfound';
	}
    include("includes/$action.html"); //allowed page
	 }

require'includes/footer.html';

?>










