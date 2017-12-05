<?php
namespace Models;

use Silex\Application;

interface InterfaceUserModel {

    /**
     *
     * @param $username username of new user
     * @param $password password of new user
     * @param $email email of new user
     * @param $role new user's role
     *
     * @param $image
     * @return bool
     */
	public function registerUser($username, $password, $email, $role, $image);

	/**
	 *
	 * @param $id id of user
	 *
	 * @return username
	 */
	public function getUsername($id);

	/**
	 *
	 * @param $username username of user
	 *
	 * @return id
	 */
	public function getId($username);

	/**
	 *
	 * @param $username
	 *
	 * @return array user details
	 */
	public function getUser($username);

	/**
	 *
	 * @param integer number of users per page
	 *
	 * @return array of users
	 */
	public function getAllUsers($digit);


	public function createArticle($title, $body, $id);
}
