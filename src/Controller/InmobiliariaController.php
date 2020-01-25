<?php

namespace App\Controller;

use App\Entity\Inmobiliaria;
use App\Entity\Usuario;
use App\Form\InmobiliariaType;
use App\Form\UsuarioType;
use App\Repository\InmobiliariaRepository;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/inmobiliaria")
 */
class InmobiliariaController extends AbstractController
{
    /**
     * @Route("/", name="inmobiliaria_index", methods={"GET"})
     */
    public function index(InmobiliariaRepository $inmobiliariaRepository): Response
    {
        return $this->render('inmobiliaria/index.html.twig', [
            'inmobiliarias' => $inmobiliariaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="inmobiliaria_new", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function new(int $id, Request $request): Response
    {
        $valid = true;
        $inmobiliarium = new Inmobiliaria();
        $form = $this->createForm(InmobiliariaType::class, $inmobiliarium);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid() && $valid) {
            $inmobiliaria_existe = $this->getDoctrine()
            ->getRepository(Inmobiliaria::class)
            ->findOneBy(array("nif"=>$_POST["inmobiliaria"]["nif"]));

            if($inmobiliaria_existe){
                $valid = false;
            }

            if($_FILES["inmobiliaria"]["type"]["logo"]!="image/jpeg"){
                $valid = false;
            }

            if($valid){

                $usuario = $this->getDoctrine()
                ->getRepository(Usuario::class)
                ->find($id);

                $inmobiliarium->setIdUsuarioAdmin($id);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($inmobiliarium);
                $entityManager->flush();

                $inmobiliaria_id=$this->getDoctrine()
                ->getRepository(Inmobiliaria::class)
                ->findOneBy(array("nif"=>$_POST["inmobiliaria"]["nif"]));
                
                $usuario->setIdInmobiliaria($inmobiliaria_id->getId());
                $entityManager->persist($usuario);
                $entityManager->flush();
                
                return $this->redirectToRoute('login');
            }else{
                return $this->redirectToRoute("inmobiliaria_new",array("id"=>$id));
            }
        }

        return $this->render('inmobiliaria/new.html.twig', [
            'inmobiliarium' => $inmobiliarium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="inmobiliaria_show", methods={"GET"})
     */
    public function show(Inmobiliaria $inmobiliarium): Response
    {
        return $this->render('inmobiliaria/show.html.twig', [
            'inmobiliarium' => $inmobiliarium,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="inmobiliaria_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Inmobiliaria $inmobiliarium): Response
    {
        $form = $this->createForm(InmobiliariaType::class, $inmobiliarium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('inmobiliaria_index');
        }

        return $this->render('inmobiliaria/edit.html.twig', [
            'inmobiliarium' => $inmobiliarium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="inmobiliaria_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Inmobiliaria $inmobiliarium): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inmobiliarium->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($inmobiliarium);
            $entityManager->flush();
        }

        return $this->redirectToRoute('inmobiliaria_index');
    }
}
