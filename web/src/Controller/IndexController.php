<?php

namespace App\Controller;

use App\Repository\PageRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexController
 * @package App\Controller
 * @Route("")
 */
class IndexController
{
    /**
     * @Template
     * @Route("/", methods={"GET"}, name="index_default")
     * @param PageRepository $pageRepository
     * @return array
     */
    public function default(PageRepository $pageRepository){
        return array('pages'=>$pageRepository->lastPage());
    }
}