<?php

namespace App\Controller;

use App\Entity\Favorito;
use App\Form\FavoritoType;
use App\Repository\FavoritoRepository;
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
     * @Route("/", name="favorito_index", methods={"GET"})
     */
    public function index(FavoritoRepository $favoritoRepository): Response
    {
        return $this->render('favorito/index.html.twig', [
            'favoritos' => $favoritoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{idInmueble}", name="favorito_new", methods={"GET","POST"})
     */
    public function new($idInmueble, Request $request)
    {
        $session = $request->getSession();

        $favorito = new Favorito();

        $favorito->setIdUsuario($session->get("usuario_id"));
        $favorito->setIdInmueble($idInmueble);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($favorito);
        $entityManager->flush();

        return $this->redirectToRoute('home_resultado',array("id"=>$idInmueble));

    }

    /**
     * @Route("/{id}", name="favorito_show", methods={"GET"})
     */
    public function show(Favorito $favorito): Response
    {
        return $this->render('favorito/show.html.twig', [
            'favorito' => $favorito,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="favorito_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Favorito $favorito): Response
    {
        $form = $this->createForm(FavoritoType::class, $favorito);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('favorito_index');
        }

        return $this->render('favorito/edit.html.twig', [
            'favorito' => $favorito,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}/{idInmueble}", name="favorito_delete", methods={"DELETE"})
     */
    public function delete($id, $idInmueble, Request $request): Response
    {
        $favorito = $this->getDoctrine()
        ->getRepository(Favorito::class)
        ->find($id); 
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($favorito);
        $entityManager->flush();

        return $this->redirectToRoute('home_resultado',array("id"=>$idInmueble));
    }
}
