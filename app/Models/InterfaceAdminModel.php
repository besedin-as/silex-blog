<?php
namespace Models;

use Silex\Application;

interface InterfaceAdminModel {
	
	/**
	 *
	 * @param string $title title of new article
	 * @param string $body body of new article
	 * @param integer $id id of article creator (admin)
	 *
	 * @return boolean
	 */
	public function createArticle($title, $body, $id);
	
	/**
	 *
	 * @param string $title title of new article
	 * @param string $body body of new article
	 * @param integer $id id of user who update (admin)
	 *
	 * @return boolean
	 */
	public function updateArticle($title, $body, $id);

	/**
	 *
	 * @param integer $id id of the article to delete
	 *
	 * @return boolean
	 */
	public function removeArticle($id);
	
	/**
	 *
	 * @param integer $id id of the user to delete
	 *
	 * @return boolean
	 */
	public function removeUser($id);
}
