<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Security\Voter\TaskVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em )
    {
        $this->em = $em;
    }

    #[Route('/tasks', name:'task_list')]
    public function listAction( TaskRepository $taskRepo):Response
    {
        return $this->render('task/list.html.twig', ['tasks' =>$taskRepo->findAll() ]);
    }

    #[Route('/tasks/close-list', name:'task_close_list')]
    public function listClose( TaskRepository $taskRepo):Response
    {
        return $this->render('task/list_close.html.twig', ['tasks' =>$taskRepo->findBy(['isDone'=> 1]) ]);
    }

    #[Route('/tasks/create', name: 'task_create')]
    public function createAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setUser( $this->getUser());
            $this->em->persist($task);
            $this->em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }


    
    #[Route("/tasks/{id}/edit", name:"task_edit")]
    
    public function editAction(Task $task, Request $request)
    {
        
        $this->denyAccessUnlessGranted(TaskVoter::TASK_EDIT, $task) ;
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    #[Route("/tasks/{id}/toggle", name:"task_toggle")]
    
    public function toggleTaskAction(Task $task)
    {


    $this->denyAccessUnlessGranted(TaskVoter::TASK_TOGGLE, $task) ;
        $task->toggle(!$task->isDone());
        $this->em->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

     
    #[Route("/tasks/{id}/delete", name:"task_delete")]
  
    public function deleteTaskAction(Task $task)
    {
        
        $this->denyAccessUnlessGranted(TaskVoter::TASK_DELETE, $task) ;
        $this->em->remove($task);
        $this->em->flush();
        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }

}
