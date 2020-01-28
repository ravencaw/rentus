<?php

namespace App\Controller;

use App\Entity\Favorito;
use App\Entity\Inmueble;
use App\Entity\Foto;
use App\Form\FavoritoType;
use App\Form\InmuebleType;
use App\Form\FotoType;
use App\Repository\FavoritoRepository;
use App\Repository\InmuebleRepository;
use App\Repository\FotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/favorito")
 */
class FavoritoController extends AbstractController
{
    /**
     * @Route("/index/{idUsuario}", name="favorito_index", methods={"GET"})
     */
    public function index($idUsuario, FavoritoRepository $favoritoRepository, Request $request): Response
    {
        $session = $request->getSession();

        if($session->get("usuario_id")){
            $favoritos = $favoritoRepository->findBy(array("id_usuario"=>$session->get("usuario_id")));
            $inmuebles = array();
            $fotos = array();

            foreach($favoritos as $f){
                $inmuebles[$f->getId()] =  $this->getDoctrine()
                ->getRepository(Inmueble::class)
                ->find($f->getIdInmueble()); 

                foreach($inmuebles as $in){
                    $fotos[$in->getId()] = $this->getDoctrine()
                    ->getRepository(Foto::class)
                    ->findOneBy(array('idInmueble'=>$in->getId()));
                }
            }

            return $this->render('favorito/index.html.twig', [
                'favoritos' => $favoritos,
                'inmuebles' => $inmuebles,
                'fotos' => $fotos
            ]);
        }else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/new/{idInmueble}", name="favorito_new", methods={"GET","POST"})
     */
    public function new($idInmueble, Request $request)
    {
        $session = $request->getSession();

        if($session->get("usuario_id")){

            $favorito = new Favorito();

            $favorito->setIdUsuario($session->get("usuario_id"));
            $favorito->setIdInmueble($idInmueble);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($favorito);
            $entityManager->flush();

            return $this->redirectToRoute('home_resultado',array("id"=>$idInmueble));

        }else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/delete/{id}/{idInmueble}", name="favorito_delete", methods={"DELETE"})
     */
    public function delete($id, $idInmueble, Request $request): Response
    {
        $session = $request->getSession();

        if($session->get("usuario_id")){
            $favorito = $this->getDoctrine()
            ->getRepository(Favorito::class)
            ->find($id); 
            
            if($favorito->getIdUsuario()==$session->get("usuario_id")){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($favorito);
                $entityManager->flush();

                return $this->redirectToRoute('favorito_index',array("idUsuario"=>$session->get("usuario_id")));
            }else{
                return $this->redirectToRoute('favorito_index',array("idUsuario"=>$session->get("usuario_id")));
            }
        }else{
            return $this->redirectToRoute('login');
        }
    }
}
