<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Page;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArticleController
 * @package App\Controller
 * @Route("api/article")
 */
class ArticleController
{
    /**
     * @Route("/add/{idPage}", methods={"POST"}, name="article_add")
     * @param $idPage
     * @param PageRepository $pageRepository
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function add($idPage, PageRepository $pageRepository, Request $request, EntityManagerInterface $entityManager){
        /** @var Page $page */
        $page = $pageRepository->find($idPage);

        $article = new Article();
        if(is_null($page)){
            throw new NotFoundHttpException('page non trouvée');
        }
        $article->setPage($page);
        $article->setDescription($request->request->get('description'));

        $entityManager->persist($article);
        $entityManager->flush();

        return new Response('');


    }
}