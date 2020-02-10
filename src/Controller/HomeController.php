<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function index()
    {
        return $this->render('index.html.twig', [
    
        ]);
    }

    /**
     * @Route("/create", name="create_task")
     */
    public function create()
    {
        return $this->render('task/create_task.html.twig', [
        
        ]);
    }


     /**
     * @Route("/edit/{id}", name="edit_task")
     */
    public function edit()
    {
        return $this->render('task/edit_task.html.twig', [
    
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete_task")
     */
    public function delete()
    {
        
  
    }
}
