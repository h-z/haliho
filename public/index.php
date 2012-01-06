<?php
/**
 * User: hz
 * Date: 2011.11.11.
 */
 
require '../lib/system/Core.php';

$core = new Core(array(
  'rootpath' => '/home/hz/projects/php/kms/')
);

print $core->page('html');


?>
