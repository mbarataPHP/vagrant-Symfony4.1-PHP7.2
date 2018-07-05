<?php

namespace App\Controller;

use App\Entity\Page;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use ErrorException;

/**
 * Class PageController
 * @package App\Controller
 * @Route("api/page")
 */
class PageController
{
    /**
     * @Route("/", methods={"GET"}, name="page_index")
     * @param PageRepository $pageRepository
     * @param Serializer $serializer
     * @return Response
     */
    public function index(PageRepository $pageRepository, Serializer $serializer){
        $pages = $pageRepository->lastPage();
        return new Response($serializer->serialize($pages, 'json'));
    }

    /**
     * @Route("/get/{id}", methods={"GET"}, name="page_get")
     * @param $id
     * @param PageRepository $pageRepository
     * @param Serializer $serializer
     * @return Response
     */
    public function get($id, PageRepository $pageRepository, Serializer $serializer){

       $page =  $pageRepository->find($id);
        return new Response($serializer->serialize($page, 'json'));

    }

    /**
     * @Route("/create", methods={"POST"}, name="page_post")
     * @see $_POST['title']
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @throws ErrorException
     */
    public function add(Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager){
        $page = new Page();
        $page->setTitle($request->request->get('title'));


        $errors = $validator->validate($page);

        if(count($errors)>0){
            throw new ErrorException('error title');
        }

        $entityManager->persist($page);
        $entityManager->flush();

        return new Response('');
    }
}