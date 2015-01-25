<?php
/**
* Class and Function List:
* Function list:
* Classes list:
*/

require_once 'application/mustache/src/Mustache/Autoloader.php';
require_once 'application/utils/utils.php';

$base_url = getCurrentUri();
$routes = array();
$path = explode('/', $base_url);
foreach ($path as $route) 
{
    
    if ($route != null && !empty(trim($route))) 
    {
        array_push($routes, trim($route));
    }
}

Mustache_Autoloader::register();
$mustache = new Mustache_Engine(array('loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '\application\templates'), 'partials_loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '\application\templates\partials')));
$template_name = null;
$data = null;

$param = route($routes);

$template = $mustache->loadTemplate($param['template_name']);
echo $template->render($param['data']);
?>