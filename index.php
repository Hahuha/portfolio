<?php
require_once ('application/mustache/src/Mustache/Autoloader.php');
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
route($routes);

/**
 * The following function will strip the script name from URL i.e.  http://www.something.com/search/book/fitzgerald
 * will become /search/book/fitzgerald
 */
function getCurrentUri() 
{
    $basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
    $uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
    if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
    $uri = '/' . trim($uri, '/');
    return $uri;
}

/**
 * Cette fonction va permettre de résoudre la route passée en paramètre pour afficher le bon résultat
 */
function route($routes) 
{
    Mustache_Autoloader::register();
    $mustache = new Mustache_Engine(array('loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '\application\templates'), 'partials_loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '\application\templates\partials')));
    $template_name = null;
    $data = null;

    // Si l'uri est vide alors on rebalance sur la page d'accueil
    if (count($routes) <= 0 || $routes[0] == "accueil") 
    {
        //include ('accueil.html');
        $template_name = "accueil";
        $data = array('parallax' => 'bg3.png');
    }
    else if ($routes[0] == "experience") 
    {
        $template_name = 'cv';
        $data = array('parallax' => 'bg3.png','nav-color' => 'amber accent-2');
    } else if ($routes[0] == "projets") 
    {
        $template_name = 'projets';
        $projets = getProjectData();
        $data = array('parallax' => 'bg2.png', 'nav-color' => 'teal accent-3', 'projets' => $projets );
    } else if ($routes[0] == "loisirs") 
    {
        $template_name = 'loisirs';
        $loisirs = getLoisirData();
        $data = array('parallax' => 'bg4.png', 'nav-color' => 'green accent-4', 'loisirs' => $loisirs);
    }
    
    if ($template_name == null || $data == null) 
    {
        //include ('accueil.html');
        $template_name = 'error';
        $data = array('title' => 'Erreur 404', 'message' => 'Page non trouvée');
    }
    
    $template = $mustache->loadTemplate($template_name);
    echo $template->render($data);
}

/**
 * Create the data to load on the loisirs section
 */
function getLoisirData() 
{
    $sports = array('id' => 'sports', 'name' => 'Sports', 'content' => array(array('name' => 'Escalade', 'img' => '<img src="media/images/climbing.jpg">', 'description' => 'Here is some more information about this product that is only revealed once clicked on. '), array('name' => 'Snowboard', 'img' => '<img src="media/images/snowboard.jpg">', 'description' => 'Here is some more information about this product that is only revealed once clicked on. ')));
    $loisirs = array('id' => 'loisirs', 'name' => 'Loisirs', 'content' => array(array('name' => 'Escalade', 'img' => '<div class="iframe-rwd"><div id="map-canvas"></div></div>', 'description' => 'Here is some more information about this product that is only revealed once clicked on. '), array('name' => 'Lecture & Jeux', 'img' => '<img src="media/images/snowboard.jpg">', 'description' => 'Here is some more information about this product that is only revealed once clicked on. ')));
    $asso = array('id' => 'associatif', 'name' => 'Associatif', 'content' => array(array('name' => 'Lecture & Jeux', 'img' => '<img src="media/images/bde.jpg">', 'description' => 'Here is some more information about this product that is only revealed once clicked on. ')));
    return array($sports, $loisirs, $asso);
}

/**
 * Create the data to load on the projects session
 */
function getProjectData() {
	$portfolio = array('name' => 'Portfolio', 'url' => 'portfolio', 'img'=>'climbing.jpg' ,'short_desc' => 'Ceci est mon projet');

	return array($portfolio);
}
?>