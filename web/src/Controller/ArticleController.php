<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Page;
use App\Form\ArticleType;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class ArticleController
 * @package App\Controller
 * @Route("article")
 */
class ArticleController
{
    /**
     * @Route("/add/{idPage}", methods={"GET", "POST"}, name="article_add")
     * @Template
     * @param $idPage
     * @param Request $request
     * @param PageRepository $pageRepository
     * @param FormFactoryInterface $formFactory
     * @param EntityManagerInterface $entityManager
     * @param RouterInterface $router
     * @return array|RedirectResponse
     */
    public function add($idPage, Request $request, PageRepository $pageRepository, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager, RouterInterface $router){

        $article = new Article();
        $page = $pageRepository->find($idPage);

        if(is_null($page)){
            throw new NotFoundHttpException('page non trouvée');
        }
        $article->setPage($page);
        $form = $formFactory->create(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Article $article */
            $article = $form->getData();

            $entityManager->persist($article);
            $entityManager->flush();

            return new RedirectResponse($router->generate('page_get', array('id' => $article->getPage()->getId())));

        }

        return array('page'=>$page, 'form'=>$form->createView());
    }
}