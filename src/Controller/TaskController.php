<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends AbstractController
{
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user_repository = $this->getDoctrine()->getRepository(User::class);
        $user = $user_repository->findAll();

        if(!$user){
           $message = "lista vacia!!";
        }else{
            $message = "200";
        }

        return $this->render('task/index.html.twig', [
            'message' => $message,
            'users' => $user
        ]);
    }
}
