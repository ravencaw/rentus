<?php

namespace App\Controller;

use App\Entity\Cita;
use App\Form\CitaType;
use App\Repository\CitaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/cita")
 */
class CitaController extends AbstractController
{
    /**
     * @Route("/index/{id}", name="cita_index", methods={"GET"})
     */
    public function index($id, CitaRepository $citaRepository): Response
    {
        return $this->render('cita/index.html.twig', [
            'citas' => $citaRepository->findByIdusuario($id),
        ]);
    }

    /**
     * @Route("/new", name="cita_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $session = $request->getSession();

        $citum = new Cita();
        $form = $this->createForm(CitaType::class, $citum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $direccion = $_POST["cita"]["direccion"].", ".$_POST["cita"]["ciudad"];
            $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($direccion).'&key=AIzaSyBX1Qy2dFMigK3r7pwgCBFC90exmctPt6g ');
            $geo = json_decode($geo, true);


            $latitud = $geo['results'][0]['geometry']['location']['lat'];
            $longitud = $geo['results'][0]['geometry']['location']['lng'];
            
            $citum->setLatitud($latitud);
            $citum->setLongitud($longitud);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($citum);
            $entityManager->flush();

            return $this->redirectToRoute('cita_index', array("id"=>$session->get("usuario_id")));
        }

        return $this->render('cita/new.html.twig', [
            'citum' => $citum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cita_show", methods={"GET"})
     */
    public function show(Cita $citum): Response
    {
        return $this->render('cita/show.html.twig', [
            'citum' => $citum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cita_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cita $citum): Response
    {
        $form = $this->createForm(CitaType::class, $citum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cita_index');
        }

        return $this->render('cita/edit.html.twig', [
            'citum' => $citum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cita_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Cita $citum): Response
    {
        $session = $request->getSession();

        if ($this->isCsrfTokenValid('delete'.$citum->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($citum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cita_index', array("id"=>$session->get("usuario_id")));
    }

    /**
     * @Route("/ajax/ajaxGetCitas", name="cita_ajaxGetCitas", methods={"POST"})
    */
    public function ajaxGetCitas(CitaRepository $citaRepository, Request $request): JsonResponse
    {
        
        $session = $request->getSession();

        $result = $citaRepository->findByIdusuario($session->get("usuario_id"));

        
        $citas = array();

        foreach($result as $res){
            $norm = array();
            $norm["id"]=$res->getId();
            $norm["fechaHora"]=$res->getFechaHora();
            $norm["id_usuario1"]=$res->getIdUsuario1();
            $norm["id_usuario2"]=$res->getIdUsuario2();
            $norm["direccion"]=$res->getDireccion();
            $norm["ciudad"]=$res->getCiudad();
            $citas[]=$norm;
        }

        return new JsonResponse($citas);
    }
}
