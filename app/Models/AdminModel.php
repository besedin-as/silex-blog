<?php
namespace Models;

use Silex\Application;
use DateTime;
use Doctrine\DBAL\Connection;
use Models\DatabaseModel;

class AdminModel extends DatabaseModel implements InterfaceAdminModel
{
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
	public function updateArticle($id, $title, $body)
	{
		$stmt = $this->queryBuilder
				->update('posts')
				->set('title', '?')
				->set('body', '?')
				->set('created', '?')
				->where('id = ?')
				->setParameter(0, $title)
				->setParameter(1, $body)
				->setParameter(2, (new DateTime("now"))->format('Y-m-d H:i:s'))
				->setParameter(3, $id);
		$stmt = $stmt->execute();
	}
	public function removeArticle($id)
	{
		$stmt = $this->queryBuilder
				->delete('posts')
				->where('id = ?')
				->setParameter(0, (int) $id);
		$stmt = $stmt->execute();
	}
	public function removeUser($id)
	{
		$stmt = $this->queryBuilder
				->delete('users')
				->where('id = ?')
				->setParameter(0, (int) $id);
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