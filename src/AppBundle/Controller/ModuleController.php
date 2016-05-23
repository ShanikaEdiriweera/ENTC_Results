<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Module;
use AppBundle\Entity\student_module_grade;   

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\NumberType; 
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;  

class ModuleController extends Controller
{

    /**
     * @Route("/module/", name="module_home")
     */
    public function indexAction(Request $request)
    {
        return $this->redirectToRoute('module_viewAll');
    }

    /**
     * @Route("/module/create", name="module_create")
     */
    public function createAction(Request $request)
    {

        $module = new Module(); 

        $form = $this->createFormBuilder($module)
            ->add('code',TextType::class)
            ->add('title', TextType::class)
            ->add('sem_id', IntegerType::class)
            ->add('credits', NumberType::class)
            ->add('gpa', ChoiceType::class, array(
                'choices' => array('GPA' => true, 'Non-GPA' => false),
                'choices_as_values' => true,
                'label'=>'GPA/Non-GPA'
                ))
            ->add('save', SubmitType::class, array('label' => 'Create Module'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            $module->save();

            return $this->redirectToRoute('module_create');
        }

        // replace this example code with whatever you need
        return $this->render('module/create.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/module/view/{id}", name="module_view")
     */
    public function viewAction($id, Request $request)
    {
        $module =  Module::getOne($id);
        return $this->render('module/view.html.twig', array('module' =>$module));  
    }

    /**
     * @Route("/module/view", name="module_viewAll")
     */
    public function viewallAction( Request $request)
    {
        $modules = Module::getAll();
        return $this->render('module/viewall.html.twig', array('modules' => $modules));

    }

    /**
     * @Route("/module/viewmoduleresults/{mod_code}", name="module_results")
     */
    public function viewmoduleresultsAction($mod_code, Request $request)
    {
        $results = student_module_grade::getModuleResults($mod_code);  
        return $this->render('module/viewmoduleresults.html.twig', array('results' => $results, 'code' => $mod_code));
    }
}



