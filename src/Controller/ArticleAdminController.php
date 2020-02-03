<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN_ARTICLE")
 */
class ArticleAdminController extends AbstractController {
	/**
	 * @Route("/admin/article/new", name="admin_article_new")
	 */
	public function new(EntityManagerInterface $em){
		die('todo');
		
		return new Response(sprintf(
			'Hiya! New Article id: #%d slug: %s',
			$article->getId(),
			$article->getSlug()
		));
	}
	
	/**
	 * @Route("/admin/article/{id}/edit", name="admin_article_edit")
	 */
	public function edit(Article $article){
		dd($article);
	}
}
