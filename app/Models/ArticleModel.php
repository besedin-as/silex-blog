<?php

namespace Models;

use Silex\Application;
use DateTime;
use Doctrine\DBAL\Connection;
use Models\DatabaseModel;

class ArticleModel extends DatabaseModel implements InterfaceArticleModel
{
    public function getAllArticles($max, $from)
    {
        $stmt = $this->queryBuilder
            ->select('*')
            ->from('posts')
            ->orderBy('created', 'DESC')
            ->setFirstResult($from)
            ->setMaxResults($max);
        $stmt = $stmt->execute();
        return $stmt->fetchAll();
    }


    public function getById($id)
    {
        $stmt = $this->queryBuilder
            ->select('id', 'title', 'body', 'created', 'id_user')
            ->from('posts')
            ->where('id = ?')
            ->setParameter(0, (int)$id);
        $stmt = $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getBySlug($slug)
    {
        $stmt = $this->queryBuilder
            ->select('title')
            ->from('posts')
            ->where('slug = ?')
            ->setParameter(0, (string)$slug);
        $stmt = $stmt->execute();

        return $stmt->fetch();
    }

    public function getComments($id)
    {
        $stmt = $this->queryBuilder
            ->select('comments.id_user', 'comments.body', 'comments.created')
            ->from('comments')
            ->where('comments.id_article = posts.id')
            ->andWhere('comments.id_article = ?')
            ->setParameter(0, (int)$id);
        $stmt = $stmt->execute();

        return $stmt->fetchAll();
    }

    public function addComment($body, $idUser, $idArticle, $ipAddress)
    {
        $stmt = $this->queryBuilder
            ->insert('comments')
            ->setValue('body', '?')
            ->setValue('id_user', '?')
            ->setValue('id_article', '?')
            ->setValue('created', '?')
            ->setValue('ip_address', '?')
            ->setParameter(0, $body)
            ->setParameter(1, $idUser)
            ->setParameter(2, $idArticle)
            ->setParameter(3, (new DateTime("now"))->format('Y-m-d H:i:s'))
            ->setParameter(4, $ipAddress);
        $stmt = $stmt->execute();

        if ($stmt) {
            return true;
        }
    }
}
