<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Admin;  
use AppBundle\Entity\Semester;   

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 

class AdminController extends Controller
{

    /**
     * @Route("/admin/", name="admin_home")
     */
    public function indexAction(Request $request)
    {
        $semesters = Semester::getAll();
        return $this->render('admin/home.html.twig', array('semesters' => $semesters));
    }

    /**
     * @Route("/admin/create", name="admin_create")
     */
    public function createAction(Request $request)
    {

        $admin = new Admin(); 

        $form = $this->createFormBuilder($admin)
            ->add('name',TextType::class)
            ->add('username', TextType::class)
            ->add('email', TextType::class)
            ->add('password', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Admin'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            $admin->setIsActive(true);
            $admin->save();

            return $this->redirectToRoute('admin_home');
        }

        // replace this example code with whatever you need
        return $this->render('admin/create.html.twig', array('form' => $form->createView()));
    }

    // /**
    //  * @Route("/admin/view/{id}", name="admin_view")
    //  */
    // public function viewAction($id, Request $request)
    // {
    //     $admin =  Admin::getOne($id);
    //     return $this->render('admin/view.html.twig', array('admin' =>$admin));  
    // }

    // /**
    //  * @Route("/admin/view", name="admin_viewAll")
    //  */
    // public function viewallAction( Request $request)
    // {
    //     $admins = Admin::getAll();
    //     return $this->render('admin/viewall.html.twig', array('admins' => $admins));

    // }
}



