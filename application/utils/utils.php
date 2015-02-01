<?php
/**
 * Class and Function List:
 * Function list:
 * - getCurrentUri()
 * - route()
 * - getLoisirData()
 * - getProjectData()
 * - getResumeData()
 * - getYamlArray()
 * Classes list:
 */
require_once 'database.php';
require_once 'translation.php';

/****************************
 * 							*
 * 		 MOD_REWRITE		*
 * 							*
 ****************************/

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
	$template_name = null;
	$data = null;
	
	$route_size = count($routes);
	
	// Si l'uri est vide alors on rebalance sur la page d'accueil
	
	if ($route_size <= 0 || $routes[0] == "accueil") 
	{
		$template_name = "accueil";
		$data = array('nav-color' => ' blue lighten-1');
	} else if ($routes[0] == "experience") 
	{
		$template_name = 'cv';
		$data = getResumeData();
	} else if ($routes[0] == "loisirs") 
	{
		$template_name = 'loisirs';
		$data = getLoisirData();
	} else if ($routes[0] == "projets") 
	{
		
		if ($route_size > 1 && !is_null($routes[1]) && !empty($routes[1])) 
		{
			$template_name = 'projet';
			
			$db = new Database();
			$data = $db->getProjectByUrl($routes[1]);
			
			//$projets = getProjectData();
			// $data = array('title' => 'Mon projet', 'parallax' => 'asset/images/background/bg4.png', 'nav-color' => 'teal accent-3', 'projets' => $projets);
			
			
		} else
		{
			$template_name = 'list_projets';
			$data = getProjectData();
		}
	}
	
	// Si aucune route n'a été trouvée on redirige vers une page d'erreur
	
	if ($template_name == null || $data == null) 
	{
		$template_name = 'error';
		$data = array('title' => 'Erreur 404', 'message' => 'Page non trouvée');
	}
	
	return array('template_name' => $template_name, 'data' => $data);
}

/****************************
 * 							*
 * 		  YAML DATA			*
 * 							*
 ****************************/
require_once __DIR__ . '\..\vendor\autoload.php';

use Symfony\Component\Yaml\Yaml;

/**
 * Create the data to load on the loisirs section
 */
function getLoisirData() 
{
	$return = new ArrayIterator(getYamlArray("asset/data/loisirs.yml"));
	foreach ($return['loisirs'] as &$list_loisir) 
	{
		$list_loisir['name'] = my_i18n($list_loisir['name']);

		foreach ($list_loisir['content'] as &$loisir) {
			$loisir['name'] = my_i18n($loisir['name']);
			$loisir['description'] = my_i18n($loisir['description']);
		}
	}
	return $return;
}

/**
 * Create the data to load on the projects session
 */
function getProjectData($project = null) 
{
	
	if (is_null($project) || empty($project)) 
	{
		$db = new Database();
		$result = $db->getProjectsSummary();
		
		$projet = getYamlArray("asset/data/projets.yml");
		$projet['projets'] = $result;
		return new ArrayIterator($projet);
	}
}

function getResumeData() 
{
	return new ArrayIterator(getYamlArray("asset/data/resume.yml"));
}

/**
 * Recupere le contenu du fichier YAML et le renvoie sous forme de tableau associatif
 */
function getYamlArray($filename) 
{
	$value = Yaml::parse(file_get_contents($filename));
	$value['title'] = my_i18n($value['title']);
	return $value;
}
?>