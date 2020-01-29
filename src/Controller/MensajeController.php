<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Repository\UsuarioRepository;
use App\Entity\Mensaje;
use App\Entity\Inmueble;
use App\Form\MensajeType;
use App\Form\InmuebleType;
use App\Repository\MensajeRepository;
use App\Repository\InmuebleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mensaje")
 */
class MensajeController extends AbstractController
{
    /**
     * @Route("/", name="mensaje_index", methods={"GET"})
     */
    public function index(MensajeRepository $mensajeRepository, Request $request): Response
    {
        $session = $request->getSession();

        if($session->get("usuario_id")){

            $mensajes=$mensajeRepository->findBy(array("idReceptor"=>$session->get("usuario_id")));
            $inmuebles = array();

            foreach($mensajes as $m){
                $inmueble =  $this->getDoctrine()
                ->getRepository(Inmueble::class)
                ->findOneBy(array('id'=>$m->getIdInmueble()));
                $inmuebles[$m->getId()]=$inmueble;
            }

            return $this->render('mensaje/index.html.twig', [
                'mensajes' => $mensajes,
                'inmuebles' => $inmuebles
            ]);

        }else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/{id}", name="mensaje_show", methods={"GET"})
     */
    public function show(Mensaje $mensaje, Request $request): Response
    {
        $session = $request->getSession();

        if($session->get("usuario_id")){
            if($mensaje->getIdReceptor()==$session->get("usuario_id")){
                $inmueble =  $this->getDoctrine()
                ->getRepository(Inmueble::class)
                ->findOneBy(array('id'=>$mensaje->getIdInmueble()));

                $usuario_existe = $this->getDoctrine()
                ->getRepository(Usuario::class)
                ->findOneBy(array("correo"=>$mensaje->getCorreo()));

                return $this->render('mensaje/show.html.twig', [
                    'mensaje' => $mensaje,
                    'inmueble' => $inmueble,
                    'usuario_existe' => $usuario_existe
                ]);
            }else{
                return $this->redirectToRoute('mensaje_index');
            }
        }else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/{id}", name="mensaje_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Mensaje $mensaje): Response
    {
        $session = $request->getSession();

        if($session->get("usuario_id")){
            if($mensaje->getIdReceptor()==$session->get("usuario_id")){
                if ($this->isCsrfTokenValid('delete'.$mensaje->getId(), $request->request->get('_token'))) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($mensaje);
                    $entityManager->flush();
                }

                return $this->redirectToRoute('mensaje_index');
            }else{
                return $this->redirectToRoute('mensaje_index');
            }
        }else{
            return $this->redirectToRoute('login');
        }
    }
}
