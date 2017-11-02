<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Pelicula;

class PeliculaController extends FOSRestController
{
    
    /**
     * @Rest\Get("/peliculas")
     */
    public function peliculasAction(Request $request)
    {
        // entity manager
        $em = $this->getDoctrine()->getManager();
        
        // repo películas
        $repoPeliculas = $em->getRepository('AppBundle:Pelicula');
        $output = array();
        
        $peliculas = $repoPeliculas->findAll();
        
        if ($peliculas) {
            foreach($peliculas as $pelicula) {
                
                //categoría
                if ($pelicula->getCategoria()) {
                    $categoria = array(
                        'id'     => $pelicula->getCategoria()->getId(),
                        'nombre' => $pelicula->getCategoria()->getNombre()
                    );
                } else {
                    $categoria = array();
                }
                
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
        } else {
            return new View('No existen película aun.', Response::HTTP_NOT_FOUND);
        }
    }
    
    /**
     * @Rest\Get("/peliculas/{id}")
     */
    public function peliculaAction(Request $request, $id)
    {
        // entity manager
        $em = $this->getDoctrine()->getManager();
        
        // repo películas
        $repoPeliculas = $em->getRepository('AppBundle:Pelicula');
        $output = array();
        
        // busca la película
        $pelicula = $repoPeliculas->find($id);
        
        if ($pelicula) {
                
            //categoría
            if ($pelicula->getCategoria()) {
                $categoria = array(
                    'id'     => $pelicula->getCategoria()->getId(),
                    'nombre' => $pelicula->getCategoria()->getNombre()
                );
            } else {
                $categoria = array();
            }
            
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
            $output = array(
                'id'          => $pelicula->getId(),
                'nombre'      => $pelicula->getNombre(),
                'descripcion' => $pelicula->getDescripcion(),
                'categoria'   => $categoria,
                'actors'      => $actores,
            );
            
            return new View($output, Response::HTTP_OK);
        } else {
            return new View('Película no encontrada', Response::HTTP_NOT_FOUND);
        }
    }
    
    /**
     * @Rest\Post("/peliculas")
     */
    public function postPeliculaAction(Request $request)
    {
        // entity manager
        $em = $this->getDoctrine()->getManager();
        
        //parametros de la petición
        $nombre = $request->request->get('nombre');
        $descripcion = $request->request->get('descripcion');
        
        // entidad
        $pelicula = new Pelicula();
        $pelicula->setNombre($nombre);
        $pelicula->setDescripcion($descripcion);
        
        // persistencia
        try {
            $em->persist($pelicula);
            $em->flush();
            return new View('Creación satisfactoria.', Response::HTTP_CREATED);
        } catch (exception $e) {
            return new View('Se presentó un error.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    /**
     * @Rest\Put("/peliculas/{id}")
     */
    public function putPeliculaAction(Request $request, $id)
    {
        // entity manager y repo
        $em = $this->getDoctrine()->getManager();
        $repoPeliculas = $em->getRepository('AppBundle:Pelicula');
        
        //parametros de la petición
        $nombre = $request->request->get('nombre');
        $descripcion = $request->request->get('descripcion');
        
        // entidad
        $pelicula = $repoPeliculas->find($id);
        $pelicula->setNombre($nombre);
        $pelicula->setDescripcion($descripcion);
        
        // persistencia
        try {
            $em->persist($pelicula);
            $em->flush();
            return new View('Actualizacion satisfactoria.', Response::HTTP_CREATED);
        } catch (exception $e) {
            return new View('Se presentó un error.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    /**
     * @Rest\Delete("/peliculas/{id}")
     */
    public function deletePeliculaAction(Request $request, $id)
    {
        // entity manager
        $em = $this->getDoctrine()->getManager();
        
        //repo  y entidad peliculas
        $repoPeliculas = $em->getRepository('AppBundle:Pelicula');
        $pelicula = $repoPeliculas->find($id);
        
        if ($pelicula) {
            // eliminacion
            $em->remove($pelicula);
            $em->flush();
            return new View("Eliminación satisfactoria", Response::HTTP_OK);
        } else {
            return new View('Película no encontrada', Response::HTTP_NOT_FOUND);
        }
    }
    
    
}
