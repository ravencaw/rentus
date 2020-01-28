<?php

// src/Controller/HomeController.php
namespace App\Controller;


use App\Entity\Inmueble;
use App\Entity\Foto;
use App\Entity\Favorito;
use App\Entity\Alerta;
use App\Form\InmuebleType;
use App\Form\FotoType;
use App\Form\FavoritoType;
use App\Form\AlertaType;
use App\Repository\InmuebleRepository;
use App\Repository\FotoRepository;
use App\Repository\FavoritoRepository;
use App\Repository\AlertaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

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
            $fotos = array();
            $ciudad = "";
            $tipo = 0;
            if(!$_POST["busqueda"]["ciudad"]){
                echo "<div class='alert alert-danger' role='alert'>Debe introducir una ciudad o un codigo postal</div>";
                return $this->redirectToRoute('home_index');
            }else if($_POST["busqueda"]["tipo"]=="0"){
                echo "<div class='alert alert-danger' role='alert'>Debe seleccionar un tipo de busqueda</div>";
                return $this->redirectToRoute('home_index');
            }else{

                $ciudad = $_POST["busqueda"]["ciudad"];
                $tipo = $_POST["busqueda"]["tipo"];

                $inmuebles = $this->getDoctrine()
                ->getRepository(Inmueble::class)
                ->findBy(array('ciudad'=>$ciudad, 'tipoInmueble'=>$tipo));

                foreach($inmuebles as $in){
                    $fotos[$in->getId()] = $this->getDoctrine()
                    ->getRepository(Foto::class)
                    ->findOneBy(array('idInmueble'=>$in->getId()));
                }
            
            }
        }
        return $this->render('home/busqueda.html.twig', [
            'inmuebles' => $inmuebles,
            'fotos' => $fotos,
            'ciudad' => $ciudad,
            'tipo' => $tipo
        ]);

    }

    public function resultado(int $id, Request $request): Response
    {
        /**
         * @Route("/resultado/{id}", name="home_resultado", methods={"GET", "POST"})
         */

        //API Maps Key:  AIzaSyBX1Qy2dFMigK3r7pwgCBFC90exmctPt6g 
        
        $session = $request->getSession();

        $inmueble = $this->getDoctrine()
        ->getRepository(Inmueble::class)
        ->find($id);

        $fotos = $this->getDoctrine()
        ->getRepository(Foto::class)
        ->findBy(array('idInmueble'=>$id));

        $alerta =  $this->getDoctrine()
        ->getRepository(Alerta::class)
        ->findOneBy(array('id_inmueble'=>$id, 'id_usuario'=>$session->get("usuario_id")));
        
        $favorito =  $this->getDoctrine()
        ->getRepository(Favorito::class)
        ->findOneBy(array('id_inmueble'=>$id, 'id_usuario'=>$session->get("usuario_id")));

        if(!$inmueble){
            return $this->redirectToRoute('home_index');
        }

        return $this->render('home/resultado.html.twig', [
            'inmueble' => $inmueble,
            'fotos' => $fotos,
            'favorito' => $favorito,
            'alerta' => $alerta
        ]);
    }

    /**
     * @Route("/ajax/ajaxGetLocalizacion", name="home_ajaxGetLocalizacion", methods={"POST"})
     */
    public function ajaxGetLocalizacion(InmuebleRepository $inmuebleRepository): JsonResponse
    {
        $result = $inmuebleRepository->findOneById($_POST["idInmueble"]);

        return new JsonResponse($result);
    }
    /**
     * @Route("/ajax/ajaxGetInmuebles", name="home_ajaxGetInmuebles", methods={"POST"})
     */
    public function ajaxGetInmuebles(InmuebleRepository $inmuebleRepository): JsonResponse
    {
        $array_filtros = array();

        $array_filtros["tipo"] = $_POST["tipo"];

        if($_POST["ciudad"]){
            $array_filtros["ciudad"] = strtoupper($_POST["ciudad"]);
        }

        if($_POST["precio_min"]){
            $array_filtros["precio_min"]=$_POST["precio_min"];
        }
        if($_POST["precio_max"]){
            $array_filtros["precio_max"]=$_POST["precio_max"];
        }
        if($_POST["superficie"]){
            $array_filtros["superficie"]=$_POST["superficie"];
        }
        if($_POST["zona"] && $_POST["zona"]!="0"){
            $array_filtros["zona"]=$_POST["zona"];
        }
        if($_POST["n_habitaciones"]){
            $array_filtros["n_habitaciones"]=$_POST["n_habitaciones"];
        }
        if($_POST["n_baños"]){
            $array_filtros["n_banyos"]=$_POST["n_baños"];
        }

        $result = $inmuebleRepository->findInmueblesFiltrados($array_filtros);
        $inmuebles = array();

        foreach($result as $res){
            $normalizers = new \Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer();
            $norm = $normalizers->normalize($res);
            $inmuebles[]=$norm;
        }
        
        return new JsonResponse($inmuebles);
    }
}