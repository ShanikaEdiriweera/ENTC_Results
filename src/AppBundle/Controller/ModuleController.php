<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Module;
use AppBundle\Entity\student_module_result;   

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 

class ModuleController extends Controller
{

    /**
     * @Route("/module/", name="student_home")
     */
    public function indexAction(Request $request)
    {
        return $this->redirectToRoute('student_viewAll');
    }

    /**
     * @Route("/student/create", name="student_create")
     */
    public function createAction(Request $request)
    {

        $student = new Student(); 

        $form = $this->createFormBuilder($student)
            ->add('indexNo',TextType::class)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Student'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            $student->save();

            return $this->redirectToRoute('student_create');
        }

        // replace this example code with whatever you need
        return $this->render('student/create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/student/view/{id}", name="student_view")
     */
    public function viewAction($id, Request $request)
    {
        $student =  Student::getOne($id);
        return $this->render('student/view.html.twig', array('student' =>$student));  
    }

    /**
     * @Route("/student/view", name="student_viewAll")
     */
    public function viewallAction( Request $request)
    {
        $students = Student::getAll();
        return $this->render('student/viewall.html.twig', array('students' => $students));

    }
}



