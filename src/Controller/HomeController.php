<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\NewTaskFormType;
use App\Form\EditTaskFormType;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function index( TaskRepository $taskRepository )
    {
        // Liste de toutes les tâches + Trie par date de création (plus recente au debut)
        $taskTable= $taskRepository->findBy(array(), array('createdAt'=>'desc'));
        return $this->render('index.html.twig', [
         'task_table'=> $taskTable
        ]);
    }

    /** 
     * @Route("/create", name="create_task")
     */
    public function create( Request $request, EntityManagerInterface $entityManager)
    {
        //traitememt formulaire creation de tache et enregistrement en base de donnée
        $taskForm= $this->createForm(NewTaskFormType::class);
        $taskForm->handleRequest($request);

        if ($taskForm->isSubmitted() && $taskForm->isValid()) {

           $task= $taskForm->getData();
           $task->setCreatedAt( New \DateTime());
           $task->setUpdatedOn( New \DateTime());
           $entityManager->persist($task);
           $entityManager->flush();

           $this->addFlash('success', 'Tache enregistrée');
           return $this->redirectToRoute('home_page');
        }


        return $this->render('task/create_task.html.twig', [
            'task_form'=> $taskForm->createView()
        ]);
    }
     /**
     * @Route("/edit/{id}", name="edit_task")
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, TaskRepository $taskRepository, $id)
    {
        //creation formulaire en recuperant la tache à editer
        $task= $taskRepository->find($id);
        $editForm= $this->createForm(EditTaskFormType::class, $task);
        $editForm->HandleRequest($request);
        
        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $tache= $editForm->getData();
            $tache->setUpdatedOn( New \DateTime());
            $entityManager->persist($tache);
            $entityManager->flush();
 
            $this->addFlash('success', 'Tache mise à jour');
            return $this->redirectToRoute('home_page');
         }

        return $this->render('task/edit_task.html.twig', [
            'edit_form'=> $editForm->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_task")
     */
    public function delete( EntityManagerInterface $entityManager, TaskRepository $taskRepository,  $id)
    {
        
        $task = $entityManager->getRepository(Task::class)->find($id);
        $entityManager->remove($task);
        $entityManager->flush();

        return $this->redirectToRoute('home_page');
    }
}


