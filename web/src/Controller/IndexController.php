<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class IndexController
 * @package App\Controller
 * @Route("")
 */
class IndexController
{
    /**
     * @Route("/", methods={"GET"}, name="index_default")
     *
     * @return Response
     */
    public function default()
    {


        return new Response('<html><body><div id="app"></div><script src="bundle.js" type="text/javascript"></script></body></html>');

    }
}