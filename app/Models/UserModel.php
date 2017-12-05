<?php
namespace Models;

use Silex\Application;
use Models\DatabaseModel;
use Doctrine\DBAL\Connection;

class UserModel extends DatabaseModel implements InterfaceUserModel {

	public function registerUser($username, $password, $email, $role = 'ROLE_USER', $image) {
		$stmt = $this->queryBuilder
				->insert('users')
				->setValue('username', '?')
				->setValue('password', '?')
				->setValue('email', '?')
				->setValue('roles', '?')
				->setValue('image', '?')
				->setParameter(0, $username)
				->setParameter(1, $password)
				->setParameter(2, $email)
				->setParameter(3, $role)
				->setParameter(4, $image);
		$stmt = $stmt->execute();

		if ($stmt) {
			return true;
		}
	}
	public function getUsername($id) {
		$stmt = $this->queryBuilder
				->select('username')
				->from('users')
				->where('id = ?')
				->setParameter(0, $id);
		$stmt = $stmt->execute();
		return $stmt->fetchColumn();
	}
	public function getId($username) {
		$stmt = $this->queryBuilder
				->select('id')
				->from('users')
				->where('username = ?')
				->setParameter(0, $username);
		$stmt = $stmt->execute();
		return $stmt->fetchColumn();
	}
	public function getUser($username) {
		$stmt = $this->queryBuilder
				->select('username', 'email', 'image')
				->from('users')
				->where('username = ?')
				->setParameter(0, $username);
		$stmt = $stmt->execute();
		return $stmt->fetch();
	}
	public function getAllUsers($digit) {
		$stmt = $this->queryBuilder
				->select('id', 'username')
				->from('users')
				->setFirstResult($digit)
				->setMaxResults(5)
				->orderBy('id', 'ASC');

		$stmt = $stmt->execute();
		return $stmt->fetchAll();
	}
    public function createArticle($title, $body, $id)
    {
        $stmt = $this->queryBuilder
            ->insert('posts')
            ->setValue('title', '?')
            ->setValue('body', '?')
            ->setValue('id_user', '?')
            ->setValue('slug', '?')
            ->setParameter(0, $title)
            ->setParameter(1, $body)
            ->setParameter(2, $id)
            ->setParameter(3, self::createSlug($title));
        $stmt = $stmt->execute();
    }
    static function createSlug($slug)
    {
        $lettersNumbersSpacesHyphens = '/[^\-\s\pN\pL]+/u';
        $spaceDuplicateHyphens = '/[\-\s]+/';

        $slug = preg_replace($lettersNumbersSpacesHyphens, '', mb_strtolower($slug));
        $slug = preg_replace($spaceDuplicateHyphens, '-', $slug);

        $slug = trim($slug, '-');
        return $slug;
    }
}