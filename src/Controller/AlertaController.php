<?php

namespace App\Controller;

use App\Entity\Alerta;
use App\Entity\Inmueble;
use App\Entity\Foto;
use App\Form\AlertaType;
use App\Form\InmuebleType;
use App\Form\FotoType;
use App\Repository\AlertaRepository;
use App\Repository\InmuebleRepository;
use App\Repository\FotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/alerta")
 */
class AlertaController extends AbstractController
{
    /**
     * @Route("/index/{idUsuario}", name="alerta_index", methods={"GET"})
     */
    public function index($idUsuario, AlertaRepository $alertaRepository, Request $request): Response
    {
        $session = $request->getSession();

        if($session->get("usuario_id")){
        
            $alertas = $alertaRepository->findBy(array("id_usuario"=>$idUsuario));
            $inmuebles = array();
            $fotos = array();

            foreach($alertas as $a){
                $inmuebles[$a->getId()] =  $this->getDoctrine()
                ->getRepository(Inmueble::class)
                ->find($a->getIdInmueble()); 

                foreach($inmuebles as $in){
                    $fotos[$in->getId()] = $this->getDoctrine()
                    ->getRepository(Foto::class)
                    ->findOneBy(array('idInmueble'=>$in->getId()));
                }
            }

            return $this->render('alerta/index.html.twig', [
                'alertas' => $alertas,
                'inmuebles' => $inmuebles,
                'fotos' => $fotos
            ]);
            
        }else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/new/{idInmueble}", name="alerta_new", methods={"GET","POST"})
     */
    public function new($idInmueble, Request $request): Response
    {
        $session = $request->getSession();
        if($session->get("usuario_id")){
            $alertum = new Alerta();

            $alertum->setIdUsuario($session->get("usuario_id"));
            $alertum->setIdInmueble($idInmueble);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($alertum);
            $entityManager->flush();

            return $this->redirectToRoute('home_resultado',array("id"=>$idInmueble));

        }else{
            return $this->redirectToRoute('login');
        }
       
    }

    /**
     * @Route("/delete/{id}/{idInmueble}", name="alerta_delete", methods={"DELETE"})
     */
    public function delete($id, $idInmueble, Request $request): Response
    {
        $session = $request->getSession();
        if($session->get("usuario_id")){
            $alertum=$this->getDoctrine()
            ->getRepository(Alerta::class)
            ->find($id);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($alertum);
            $entityManager->flush();

            return $this->redirectToRoute('home_resultado',array("id"=>$idInmueble));
        }else{
            return $this->redirectToRoute('login');
        }
    }
}
