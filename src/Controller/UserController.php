<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Form\RegisterType;

class UserController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
    }

    public function modificar(Request $request, User $user, UserPasswordEncoderInterface $encoder){
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            $em->flush();
            return $this->redirect($this->generateUrl('home'));
        }
        return $this->render('user/editar.html.twig', ['form' => $form->createView()]);
    }
}
