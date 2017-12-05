<?php
namespace Models;

use Silex\Application;

interface InterfaceArticleModel {

    /**
     * @param $limit
     * @param $from
     * @return array of articles
     * @internal param number $integer of articles to return
     *
     */
	public function getAllArticles($max, $from);


	/**
	 * 
	 * @param integer $id id of article
	 * @param string $slug slug of article
	 * 
	 * @return article
	 */
	public function getById($id);

	public function getBySlug($slug);


	/**
	 * @param integer $id id of article
	 * 
	 * @return array of comments
	 */
	public function getComments($id);

	/**
	 * @param $body body of comment
	 * @param $idUser id of user who adding comment
	 * @param $idArticle id of article where comment is adding
	 * @param $ipAddress ip address of user who adding comment
	 *
	 * @return boolean
	 */
	public function addComment($body, $idUser, $idArticle, $ipAddress);
}