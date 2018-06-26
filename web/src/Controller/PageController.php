<?php

namespace App\Controller;

use App\Entity\Page;
use App\Form\PageType;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class PageController
 * @package App\Controller
 * @Route("page")
 */
class PageController
{
    /**
     * @Route("/add", methods={"GET", "POST"}, name="page_add")
     * @Template
     * @param Request $request
     * @param FormFactoryInterface $formFactory
     * @param EntityManagerInterface $entityManager
     * @param RouterInterface $router
     * @return array|RedirectResponse
     */
    public function add(Request $request, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager, RouterInterface $router){

        $page = new Page();


        $form = $formFactory->create(PageType::class, $page);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Page $page */
            $page = $form->getData();

            $entityManager->persist($page);
            $entityManager->flush();

            return new RedirectResponse($router->generate('page_get', array('id' => $page->getId())));

        }

        return array('form'=>$form->createView());
    }

    /**
     * @Route("/get/{id}", methods={"GET"}, name="page_get")
     * @Template
     * @param $id
     * @param PageRepository $pageRepository
     * @return array
     */
    public function get($id, PageRepository $pageRepository){

        $page = $pageRepository->find($id);

        if(is_null($page)){
            throw new NotFoundHttpException('page non trouvée');
        }

        return array('page'=>$page);
    }
}