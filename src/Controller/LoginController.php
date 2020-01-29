<?php
// src/Controller/LoginController.php
namespace App\Controller;

use App\Entity\Usuario;
use App\Form\LoginType;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/login")
 */
class LoginController extends AbstractController
{
    public function index(Request $request): Response
    {
        /**
         * @Route("/", name="login_index", methods={"GET", "POST"})
         */
        
        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usuario = $this->getDoctrine()
                ->getRepository(Usuario::class)
                ->findOneBy(array("correo"=>$_POST["login"]["correo"]));

            if($usuario){
                if(password_verify($_POST["login"]["password"], $usuario->getPassword())){
                    $session = $request->getSession();

                    $session->start();

                    $session->clear();

                    $session->set('usuario_id', $usuario->getId());
                    $session->set('usuario_nombre', $usuario->getNombre());
                    $session->set('usuario_inmobiliaria', $usuario->getIdInmobiliaria());
                    
                    return $this->redirectToRoute('home_index');
                }else{
                    echo "<div class='alert alert-danger' role='alert'>La contraseña introducida es incorrecta</div>";
                }
            }else{
                echo "<div class='alert alert-danger' role='alert'>El usuario es incorrecto</div>";
            }
        }

        return $this->render('login/index.html.twig',[
            'form' => $form->createView(),
        ]);

        
    }

    public function logout(Request $request)
    {
        /**
         * @Route("/logout", name="logout_index", methods={"GET", "POST"})
         */
        
        $session = $request->getSession();

        $session->start();
        
        $session->invalidate();
        $session->clear();

        return $this->redirectToRoute('login');
    }
}