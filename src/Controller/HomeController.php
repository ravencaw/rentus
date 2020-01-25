<?php

// src/Controller/HomeController.php
namespace App\Controller;


use App\Entity\Inmueble;
use App\Entity\Foto;
use App\Form\InmuebleType;
use App\Form\FotoType;
use App\Repository\InmuebleRepository;
use App\Repository\FotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/home")
 */
class HomeController extends AbstractController
{
    public function index(Request $request): Response
    {
        /**
         * @Route("/", name="home_index", methods={"GET", "POST"})
         */
        return $this->render('home/index.html.twig');

    }

    public function busqueda(Request $request): Response
    {
        /**
         * @Route("/busqueda", name="home_busqueda", methods={"GET", "POST"})
         */
        
        if(isset($_POST["buscar"])){
            $inmuebles = null;
            
            if(!$_POST["busqueda"]["ciudad"]){
                echo "<div class='alert alert-danger' role='alert'>Debe introducir una ciudad o un codigo postal</div>";
            }else if($_POST["busqueda"]["tipo"]=="0"){
                echo "<div class='alert alert-danger' role='alert'>Debe seleccionar un tipo de busqueda</div>";
            }else{
                $inmuebles = $this->getDoctrine()
                ->getRepository(Inmueble::class)
                ->findBy(array('ciudad'=>$_POST["busqueda"]["ciudad"], 'tipoInmueble'=>$_POST["busqueda"]["tipo"]));
            }
        }
        return $this->render('home/busqueda.html.twig', [
            'inmuebles' => $inmuebles
        ]);

    }

    public function resultado(int $id, Request $request): Response
    {
        /**
         * @Route("/resultado/{id}", name="home_resultado", methods={"GET", "POST"})
         */

        //API Maps Key:  AIzaSyBX1Qy2dFMigK3r7pwgCBFC90exmctPt6g 

        $inmueble = $this->getDoctrine()
        ->getRepository(Inmueble::class)
        ->find($id);

        $fotos = $this->getDoctrine()
        ->getRepository(Foto::class)
        ->findBy(array('idInmueble'=>$id));

        if(!$inmueble){
            return $this->redirectToRoute('home_index');
        }

        return $this->render('home/resultado.html.twig', [
            'inmueble' => $inmueble,
            'fotos' => $fotos
        ]);
    }
}