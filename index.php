<?php
/**
 * Class and Function List:
 * Function list:
 * - (()
 * Classes list:
 */

require_once 'application/mustache/src/Mustache/Autoloader.php';
require_once 'application/utils/utils.php';
require_once 'application/vendor/autoload.php';
require_once 'application/utils/translation.php';

use Symfony\Component\Yaml\Yaml;

// Si aucune locale n'est définie, on la définit selon celle du client
session_start();
if (getSessionLocale() == null) 
{
    $locale = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
    setSessionLocale($locale);
}

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

if (count($routes) >= 2 && $routes[0] == "locale") 
{
    setSessionLocale($routes[1]);
    echo getSessionLocale();
} else
{
    $param = route($routes);
    
    Mustache_Autoloader::register();
    $mustache = new Mustache_Engine(array('loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '\application\templates'), 'partials_loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '\application\templates\partials'), 'helpers' => array('i18n' => function ($text) 
    {
        return my_i18n($text);
    },)));
    
    $template = $mustache->loadTemplate($param['template_name']);
    echo $template->render($param['data']);
}
?>