<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Form\CreateTask;

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

    public function crear_task(Request $request, UserInterface $user){
        $task = new Task;
        $form = $this->createForm(CreateTask::class, $task);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $task->setCreatedAt(new \DateTime('now'));
            $task->setUser($user);
            $em->persist($task);
            $em->flush();

            return $this->redirect($this->generateUrl('home'));
        }
        return $this->render('task/crearTask.html.twig', ['form' => $form->createView()]);
    }

    public function ver_tarea(Task $task){
        if(!$task){
          return $this->redirectToRoute('home');
        }
        return $this->render('task/detail.html.twig', ['task' => $task]);
    }

    public function eliminar_tarea(Task $task){
        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();
        return $this->redirectToRoute('home');
    }

    public function editar_tarea(Request $request, Task $task, UserInterface $user){
        $form = $this->createForm(CreateTask::class, $task);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $task->setCreatedAt(new \DateTime('now'));
            $task->setUser($user);
            $em->persist($task);
            $em->flush();

            return $this->redirect($this->generateUrl('home'));
        }
        return $this->render('task/crearTask.html.twig', ['form' => $form->createView(),'edit' => true]);

    }
}
