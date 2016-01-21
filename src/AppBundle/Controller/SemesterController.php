<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request; 
use AppBundle\Entity\Semester;   
use AppBundle\Entity\Semester_results;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 

class SemesterController extends Controller
{

    /**
     * @Route("/semester/", name="semester_home")
     */
    public function indexAction(Request $request)
    {
        return $this->redirectToRoute('semester_viewAll');
    }

    // /**
    //  * @Route("/semester/create", name="semester_create")
    //  */
    // public function createAction(Request $request)
    // {

    //     $semester = new Semester(); 

    //     $form = $this->createFormBuilder($semester)
    //         ->add('name',TextType::class)
    //         ->add('save', SubmitType::class, array('label' => 'Create Semester'))
    //         ->getForm();

    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         // ... perform some action, such as saving the task to the database
    //         $semester->save();

    //         return $this->redirectToRoute('semester_home');
    //     }

    //     // replace this example code with whatever you need
    //     return $this->render('semester/create.html.twig', array('form' => $form->createView()));
    // }

    /**
     * @Route("/semester/view/{id}", name="semester_view")
     */
    public function viewAction($id, Request $request)
    {
        $semester =  Semester::getOne($id);
        return $this->render('semester/view.html.twig', array('semester' =>$semester));  
    }

    /**
     * @Route("/semester/view", name="semester_viewAll")
     */
    public function viewallAction( Request $request)
    {
        $semesters = Semester::getAll();
        return $this->render('semester/viewall.html.twig', array('semesters' => $semesters));
    }
}



