<?php

/**
* Classe permettant de gérer les informations contenues dans la base de données SQLite
*/
class Database
{
	public $db;
	
	function __construct()
	{
		$this->db = new SQLite3('asset/data/projetDB.sqlite');
	}

	function execute ($query) {
		$this->db->exec($query);

	}
}
?>