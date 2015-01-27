<?php
/**
* Class and Function List:
* Function list:
* - my_i18n()
* - setSessionLocale()
* - getSessionLocale()
* Classes list:
*/

/****************************
 * 							*
 * 		  	I18N			*
 * 							*
 ****************************/
require_once __DIR__ . '\..\vendor\autoload.php';
require_once ('/../i18n/I18n.php');

use Symfony\Component\Yaml\Yaml;

I18n\I18n::set_backend(null);
I18n\I18n::push_load_path(__DIR__ . '\..\..\asset\i18n\messages.yml');
$base = I18n\I18n::get_backend();

function my_i18n($text) 
{
	global $base;
	
	return $base->translate(getSessionLocale(), $text, array('locale' => 'fr'));
}

function setSessionLocale($locale) 
{
	if (is_null($locale) || empty($locale)) 
	{
		$_SESSION['locale'] = 'en';
	} else
	{
		$tmp = explode("_", $locale);
		$locale = $tmp[0];
		
		if ($locale != "en" && $locale != "fr") $locale = "en";
		
		$_SESSION['locale'] = $locale;
	}
}

function getSessionLocale() 
{
	if (isset($_SESSION['locale'])) 
	{
		return $_SESSION['locale'];
	}
	
	return null;
}
?>