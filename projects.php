<?php
require_once('application/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();
$mustache = new Mustache_Engine(array(
'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'\application\templates')
));
$template = $mustache->loadTemplate('welcomepage');
echo $template->render(array('firstname' => 'John', 'visitorNumber' => 7));
?>