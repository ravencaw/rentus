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
     * @Route("/new", name="favorito_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $favorito = new Favorito();
        $form = $this->createForm(FavoritoType::class, $favorito);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($favorito);
            $entityManager->flush();

            return $this->redirectToRoute('favorito_index');
        }

        return $this->render('favorito/new.html.twig', [
            'favorito' => $favorito,
            'form' => $form->createView(),
        ]);
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
     * @Route("/{id}", name="favorito_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Favorito $favorito): Response
    {
        if ($this->isCsrfTokenValid('delete'.$favorito->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($favorito);
            $entityManager->flush();
        }

        return $this->redirectToRoute('favorito_index');
    }
}
