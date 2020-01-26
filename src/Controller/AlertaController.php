<?php

namespace App\Controller;

use App\Entity\Alerta;
use App\Form\AlertaType;
use App\Repository\AlertaRepository;
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
     * @Route("/", name="alerta_index", methods={"GET"})
     */
    public function index(AlertaRepository $alertaRepository): Response
    {
        return $this->render('alerta/index.html.twig', [
            'alertas' => $alertaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="alerta_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $alertum = new Alerta();
        $form = $this->createForm(AlertaType::class, $alertum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($alertum);
            $entityManager->flush();

            return $this->redirectToRoute('alerta_index');
        }

        return $this->render('alerta/new.html.twig', [
            'alertum' => $alertum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="alerta_show", methods={"GET"})
     */
    public function show(Alerta $alertum): Response
    {
        return $this->render('alerta/show.html.twig', [
            'alertum' => $alertum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="alerta_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Alerta $alertum): Response
    {
        $form = $this->createForm(AlertaType::class, $alertum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('alerta_index');
        }

        return $this->render('alerta/edit.html.twig', [
            'alertum' => $alertum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="alerta_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Alerta $alertum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$alertum->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($alertum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('alerta_index');
    }
}
