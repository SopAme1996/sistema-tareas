<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Form\RegisterType;
class LoginController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('login/index.html.twig');
    }

    public function register(): Response{
        $form = $this->createForm(RegisterType::class);
        // $form->handleRequest($request);
        // if($form->isSubmitted()){
        //     $data = $form->getData();
        //     $user->setRole('ROLE_USER');
        // }
        return $this->render('login/register.html.twig', ['form' => $form->createView()]);
    }

    public function saveRegister(Request $request, UserPasswordEncoderInterface $encoder){
        $usuario = $request->get("register");
        if($usuario){
            $user = new User();
            $user->setRole('ROLE_USER');
            $user->setName($usuario['name']);
            $user->setSurname($usuario['surname']);
            $user->setEmail($usuario['email']);
            $encoded = $encoder->encodePassword($user, $usuario['password']);
            $user->setPassword($encoded);
            $user->setCreatedAt(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('login');
        }else{
            //Pendiente
        }
    }
}
