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
        $output = array();
        
        $peliculas = $repoPeliculas->findAll();
        
        foreach($peliculas as $pelicula) {
            
            //categoría
            $categoria = array(
                'id'     => $pelicula->getCategoria()->getId(),
                'nombre' => $pelicula->getCategoria()->getNombre()
            );
            
            //actores
            $actores = array();
            foreach ($pelicula->getActors() as $actor) {
                $actores[] = array(
                    'id'             => $actor->getId(),
                    'nombre'         => $actor->getNombre(),
                    'anioNacimiento' => $actor->getAnioNacimiento()
                );
            }
            
            //peliculas
            $output[] = array(
                'id'          => $pelicula->getId(),
                'nombre'      => $pelicula->getNombre(),
                'descripcion' => $pelicula->getDescripcion(),
                'categoria'   => $categoria,
                'actors'      => $actores,
            );
        }
        
        return new View($output, Response::HTTP_OK);
    }
    
    /**
     * @Rest\Get("/peliculas/{id}")
     */
    public function peliculaAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $repoPeliculas = $em->getRepository('AppBundle:Pelicula');
        $output = array();
        
        $pelicula = $repoPeliculas->find($id);
        
            
        //categoría
        $categoria = array(
            'id'     => $pelicula->getCategoria()->getId(),
            'nombre' => $pelicula->getCategoria()->getNombre()
        );
        
        //actores
        $actores = array();
        foreach ($pelicula->getActors() as $actor) {
            $actores[] = array(
                'id'             => $actor->getId(),
                'nombre'         => $actor->getNombre(),
                'anioNacimiento' => $actor->getAnioNacimiento()
            );
        }
        
        //peliculas
        $output[] = array(
            'id'          => $pelicula->getId(),
            'nombre'      => $pelicula->getNombre(),
            'descripcion' => $pelicula->getDescripcion(),
            'categoria'   => $categoria,
            'actors'      => $actores,
        );
        
        return new View($output, Response::HTTP_OK);
    }
    
    
    
}
