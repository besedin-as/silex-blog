<?php
namespace Models;

use Silex\Application;

interface InterfaceMainModel {
	
	/**
	 * @return array of main articles
	 */
	public function getMainArticles();
}
