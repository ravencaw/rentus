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
     * @Route("/index/{id}", name="inmueble_index", methods={"GET"})
     */
    public function index(int $id, InmuebleRepository $inmuebleRepository): Response
    {
        return $this->render('inmueble/index.html.twig', [
            'inmuebles' => $inmuebleRepository->findBy(array("idCreador"=>$id)),
        ]);
    }

    /**
     * @Route("/new", name="inmueble_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $session = $request->getSession();

        $inmueble = new Inmueble();
        $form = $this->createForm(InmuebleType::class, $inmueble);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $direccion = $_POST["inmueble"]["direccion"].", ".$_POST["inmueble"]["ciudad"]." ".$_POST["inmueble"]["cp"];
            $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($direccion).'&key=AIzaSyBX1Qy2dFMigK3r7pwgCBFC90exmctPt6g ');
            $geo = json_decode($geo, true);


            $latitud = $geo['results'][0]['geometry']['location']['lat'];
            $longitud = $geo['results'][0]['geometry']['location']['lng'];
            
            $inmueble->setLatitud($latitud);
            $inmueble->setLongitud($longitud);

            $inmueble->setIdCreador($session->get("usuario_id"));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($inmueble);
            $entityManager->flush();

            return $this->redirectToRoute('inmueble_index',array("id"=>$session->get("usuario_id")));
        }

        return $this->render('inmueble/new.html.twig', [
            'inmueble' => $inmueble,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("show/{id}", name="inmueble_show", methods={"GET"})
     */
    public function show(int $id, InmuebleRepository $inmuebleRepository): Response
    {
        return $this->render('inmueble/show.html.twig', [
            'inmueble' => $inmuebleRepository->find($id),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="inmueble_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Inmueble $inmueble): Response
    {
        $session = $request->getSession();

        $form = $this->createForm(InmuebleType::class, $inmueble);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $direccion = $_POST["inmueble"]["direccion"].", ".$_POST["inmueble"]["ciudad"]." ".$_POST["inmueble"]["cp"];
            $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($direccion).'&key=AIzaSyBX1Qy2dFMigK3r7pwgCBFC90exmctPt6g ');
            $geo = json_decode($geo, true);


            $latitud = $geo['results'][0]['geometry']['location']['lat'];
            $longitud = $geo['results'][0]['geometry']['location']['lng'];
                
            $inmueble->setLatitud($latitud);
            $inmueble->setLongitud($longitud);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('inmueble_index',array("id"=>$session->get("usuario_id")));
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
        $session = $request->getSession();
        if ($this->isCsrfTokenValid('delete'.$inmueble->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($inmueble);
            $entityManager->flush();
        }

        return $this->redirectToRoute('inmueble_index',array("id"=>$session->get("usuario_id")));
    }

    
}
