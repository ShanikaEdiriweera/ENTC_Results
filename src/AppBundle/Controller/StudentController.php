<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Student;
use AppBundle\Entity\student_module_grade;
use AppBundle\Entity\Semester_results;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 

class StudentController extends Controller
{

    /**
     * @Route("/student/", name="student_home")
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
        //get module results of the student
        $results = student_module_grade::getStudentModuleResults($id);
        //get semester results of the student
        $semResults = Semester_results::getSemesterResults($id);
        return $this->render('student/view.html.twig', array('student' =>$student, 'results'=>$results, 'semResults'=>$semResults));  
    }

    /**
     * @Route("/student/view", name="student_viewAll")
     */
    public function viewallAction( Request $request)
    {
        $students = Student::getAll();
        return $this->render('student/viewall.html.twig', array('students' => $students));

    }

    /**
     * @Route("/student/update", name="student_cgpa_update")
     */
    public function updateAction(Request $request)
    {
        //With doctrine
        $students = $this->getDoctrine()->getRepository('AppBundle:Student')->findAll();
        $results = $this->getDoctrine()->getRepository('AppBundle:Semester_results')->findAll();

        $em = $this->getDoctrine()->getManager();

        //looping through each student
        foreach($students as $student){
            $totalMarks = 0.0000;
            $totalCredits = 0.0;

            //looping through each semester_result
            foreach($results as $result){
                if($student->getId() == $result->getStuId()){
                    $totalMarks += $result->getGPA() * $result->getSemCredits();
                    $totalCredits += $result->getSemCredits();
                }
            }

            //setting student CGPA
            if($totalCredits>0)
                $student->setCGPA($totalMarks/$totalCredits);
            else
                $student->setCGPA(0);

            $em->persist($student);
            $em->flush();
        }

        $students= $this->getDoctrine()->getRepository('AppBundle:Student')->findBy(array(),array('cGPA' => 'DESC') );
        $rank = 1;
        $lastGpa = 5.0000;
        //to catch equal ranks
        $lastRank = 0;
        // set ranks 
        foreach ($students as $student) {
            if ($student->getCGPA() == $lastGpa) {
                $student->setRank($lastRank);
            }else{
                $student->setRank($rank);
                $lastRank = $rank;
            }
            $rank++;
            $lastGpa = $student->getCGPA();

            $em->persist($student);
            $em->flush();
           //echo $result->getStuId()."<br>";
        }

        //die();
        return $this->redirectToRoute('student_home');
    }
}



