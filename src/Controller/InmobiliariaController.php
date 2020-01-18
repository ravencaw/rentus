<?php

namespace App\Controller;

use App\Entity\Inmobiliaria;
use App\Form\InmobiliariaType;
use App\Repository\InmobiliariaRepository;
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
     * @Route("/new", name="inmobiliaria_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $inmobiliarium = new Inmobiliaria();
        $form = $this->createForm(InmobiliariaType::class, $inmobiliarium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($inmobiliarium);
            $entityManager->flush();

            return $this->redirectToRoute('inmobiliaria_index');
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
