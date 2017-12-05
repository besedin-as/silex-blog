<?php
namespace Models;

use Silex\Application;
use Models\DatabaseModel;
use Doctrine\DBAL\Connection;

class MainModel extends DatabaseModel implements InterfaceMainModel
{
	public function getMainArticles()
	{
		$stmt = $this->queryBuilder
				->select('*')
				->from('posts')
				->orderBy('created', 'DESC')
				->setMaxResults(3);
		$stmt = $stmt->execute();
		
		return $stmt->fetchAll();
	}

}
