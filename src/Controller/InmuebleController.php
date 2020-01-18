<?php

namespace App\Controller;

use App\Entity\Inmueble;
use App\Form\InmuebleType;
use App\Repository\InmuebleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/inmueble")
 */
class InmuebleController extends AbstractController
{
    /**
     * @Route("/", name="inmueble_index", methods={"GET"})
     */
    public function index(InmuebleRepository $inmuebleRepository): Response
    {
        return $this->render('inmueble/index.html.twig', [
            'inmuebles' => $inmuebleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="inmueble_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $inmueble = new Inmueble();
        $form = $this->createForm(InmuebleType::class, $inmueble);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($inmueble);
            $entityManager->flush();

            return $this->redirectToRoute('inmueble_index');
        }

        return $this->render('inmueble/new.html.twig', [
            'inmueble' => $inmueble,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="inmueble_show", methods={"GET"})
     */
    public function show(Inmueble $inmueble): Response
    {
        return $this->render('inmueble/show.html.twig', [
            'inmueble' => $inmueble,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="inmueble_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Inmueble $inmueble): Response
    {
        $form = $this->createForm(InmuebleType::class, $inmueble);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('inmueble_index');
        }

        return $this->render('inmueble/edit.html.twig', [
            'inmueble' => $inmueble,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="inmueble_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Inmueble $inmueble): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inmueble->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($inmueble);
            $entityManager->flush();
        }

        return $this->redirectToRoute('inmueble_index');
    }
}
