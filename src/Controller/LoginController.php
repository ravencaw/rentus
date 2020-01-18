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
                ->findOneByCorreoAndPass($_POST["login"]["correo"], $_POST["login"]["password"]);

            if($usuario){
                
                $_SESSION["usuario_id"]=$usuario["id"];
                $_SESSION["usuario_inmobiliaria"] = ($usuario["idInmobiliaria"])?$usuario["idInmobiliaria"]:"NULL";

                return $this->redirectToRoute('home_index');
            }else{
                echo "<div class='alert alert-danger' role='alert'>El usuario o la contraseña son incorrectos</div>";
            }
        }

        return $this->render('login/index.html.twig',[
            'form' => $form->createView(),
        ]);

        
    }
}