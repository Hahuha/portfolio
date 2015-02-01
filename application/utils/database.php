<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - execute()
 * - getProjectsSummary()
 * - getProjectByUrl()
 * Classes list:
 * - Database
 */
require_once 'translation.php';

/**
 * Classe permettant de gérer les informations contenues dans la base de données SQLite
 */
class Database
{
	
	/**
	 * Objet SQLite3 permettant d'accéder à la BDD
	 */
	public $db;
	
	function __construct() 
	{
		$this->db = new SQLite3('asset/data/projetDB.sqlite');
	}
	
	function execute($query) 
	{
		$this->db->exec($query);
	}
	
	/**
	 * Renvoie tous les projets contenus dans la table sous forme de tableau associatif.
	 * Contient seulement les données résumées.
	 */
	public function getProjectsSummary() 
	{
		$result = $this->db->query('SELECT name, url, main_img as img, short_desc FROM projets ORDER BY "ORDER"');
		if (!$result) 
		{
			return false;
		}
		
		$return = array();
		while ($row = $result->fetchArray()) 
		{
			$row['name'] = my_i18n($row['name']);
			$row['short_desc'] = my_i18n($row['short_desc']);
			array_push($return, $row);
		}
		
		return $return;
	}
	
	/**
	 * Renvoie toutes les données d'un projet sous forme de tableau associatif
	 */
	public function getProjectByUrl($url) 
	{
		$result = $this->db->querySingle('SELECT name, main_img as parallax, main_color as "nav-color", goal, description, techno FROM projets ORDER BY "ORDER"', true);
		$result['name'] = my_i18n($result['name']);
		$result['goal'] = my_i18n($result['goal']);
		$result['description'] = my_i18n($result['description']);
		$result['techno'] = my_i18n($result['techno']);
		
		return $result;
	}
}
?>