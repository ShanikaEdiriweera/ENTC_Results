<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\student_module_grade;
use AppBundle\Entity\Student;
use AppBundle\Entity\Grade;
use AppBundle\Entity\Module;   

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; 

class ResultController extends Controller
{

    /**
     * @Route("/result/", name="result_home")
     */
    public function indexAction(Request $request)
    {
        return $this->redirectToRoute('result_viewAll');
    }

    /**
     * @Route("/result/create", name="result_create")
     */
    public function createAction(Request $request)
    {

        $result = new student_module_grade(); 

        // generating data for the form
        $students =  Student::getAll();
        $studentIds = array();
        foreach ($students as $student) {
            $studentIds[$student->getIndexNo()] = $student->getIndexNo(); 
            //array_push($studentIds, $student->getIndexNo());
        }

        $modules =  Module::getAll();
        $moduleIds = array();
        foreach ($modules as $module) {
            $moduleIds[$module->getCode()] = $module->getCode();
            //array_push($moduleIds, $module->getCode()); 
        }

        $grades =  Grade::getAll();
        $gradeIds = array();
        foreach ($grades as $grade) {
            $gradeIds[$grade->getGrade()] = $grade->getGrade();
            //array_push($gradeIds, $grade->getGrade()); 
        }

        $form = $this->createFormBuilder($result)
            ->add('s_id', ChoiceType::class, array(
                'choices' => $studentIds,
                'choices_as_values' => true,
                'label'=>'Index No'
                ))
            ->add('m_code',ChoiceType::class, array(
                'choices'  => $moduleIds,
                'choices_as_values' => true,
                'label'=>'Module'
                    ))
            ->add('grade',ChoiceType::class, array(
                'choices'  => $gradeIds,
                'choices_as_values' => true,
                'label'=>'Grade'
                    ))
            ->add('save', SubmitType::class, array('label' => 'Add Marks'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            $result->save();

            return $this->redirectToRoute('result_create');
        }

        // replace this example code with whatever you need
        return $this->render('result/create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/result/view/{id}", name="result_view")
     */
    public function viewAction($id, Request $request)
    {
        $result =  student_module_grade::getOne($id);
        return $this->render('result/view.html.twig', array('result' =>$result));  
    }

    /**
     * @Route("/result/view", name="result_viewAll")
     */
    public function viewallAction( Request $request)
    {
        $results = student_module_grade::getAll();
        return $this->render('result/viewall.html.twig', array('results' => $results));

    }
}



