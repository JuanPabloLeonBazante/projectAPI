<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

class DefaultController extends FOSRestController
{
    /**
     * @Rest\Get("/")
     */
    public function indexAction(Request $request)
    {
        $respuesta = array(
            'mensaje' => 'Ruta no permitida, por favor consulte la documentación.'
        );
        return new View($respuesta, Response::HTTP_BAD_REQUEST);
    }
    
    /**
     * @Rest\Get("/peliculas")
     */
    public function peliculasAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $repoPeliculas = $em->getRepository('AppBundle:Pelicula');
        
        $peliculas = $repoPeliculas->findAll();
        
        return new View($peliculas, Response::HTTP_OK);
    }
    
    
    
}
