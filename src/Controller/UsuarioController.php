<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/usuario")
 */
class UsuarioController extends AbstractController
{
    /**
     * @Route("/", name="usuario_index", methods={"GET"})
     */
    /*public function index(UsuarioRepository $usuarioRepository, Request $request): Response
    {
        $session = $request->getSession();
        if($session->get("usuario_id")){
            if($session->get("usuario_inmobiliaria")){
                return $this->render('usuario/index.html.twig', [
                    'usuarios' => $usuarioRepository->findBy(array("id_inmueble"=>$session->get("usuario_inmobiliaria"))),
                ]);
            }else{
                return $this->redirectToRoute('home_index', array("id"=>$session->get("usuario_id")));
            }
        }else{
            return $this->redirectToRoute('login');
        }
    }*/

    /**
     * @Route("/new", name="usuario_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $valid = true;
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usuario_existe = $this->getDoctrine()
            ->getRepository(Usuario::class)
            ->findOneBy(array("correo"=>$_POST["usuario"]["correo"]));

            if($usuario_existe){
                $valid = false;
            }
            if($valid){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($usuario);
                $entityManager->flush();

                if(!isset($_POST["new_inmobiliaria"])){
                    return $this->redirectToRoute('login');
                }else{
                    $usuario_id = $this->getDoctrine()
                    ->getRepository(Usuario::class)
                    ->findOneByCorreoAndPass($_POST["usuario"]["correo"], $_POST["usuario"]["password"]);
                    return $this->redirectToRoute("inmobiliaria_new",array("id"=>$usuario_id['id']));
                }
            }else{
                return $this->redirectToRoute('usuario_new');
            }
            
        } 


        return $this->render('usuario/new.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="usuario_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Usuario $usuario): Response
    {
        $session = $request->getSession();

        if($session->get("usuario_id")){
            if($usuario->getId()==$session->get("usuario_id")){
                $form = $this->createForm(UsuarioType::class, $usuario);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $this->getDoctrine()->getManager()->flush();

                    return $this->redirectToRoute('usuario_edit', array("id"=>$session->get("usuario_id")));
                }

                return $this->render('usuario/edit.html.twig', [
                    'usuario' => $usuario,
                    'form' => $form->createView(),
                ]);
            }else{
                return $this->redirectToRoute('usuario_edit', array("id"=>$session->get("usuario_id")));
            }
        }else{
            return $this->redirectToRoute('login');
        }
    }

    /**
     * @Route("/{id}", name="usuario_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Usuario $usuario): Response
    {
        $session = $request->getSession();
        if($session->get("usuario_id")){
            if ($this->isCsrfTokenValid('delete'.$usuario->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($usuario);
                $entityManager->flush();
            }

            return $this->redirectToRoute('usuario_index');

        }else{
            return $this->redirectToRoute('login');
        }
    }
}
