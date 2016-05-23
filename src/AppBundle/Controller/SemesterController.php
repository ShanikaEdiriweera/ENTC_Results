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

    /**
     * @Route("/semester/update/{id}", name="semester_update")
     */
    public function updateAction($id,Request $request)
    {
        //there is an error - Warning: mysqli::prepare(): Couldn't fetch mysqli occurring - check

        // $results = Semester_results::updateGpa($id);

        // //
        // foreach ($results as $result) {
        //     $result->save();
        // }

        // return $this->redirectToRoute('semester_home');


        //With doctrine
        $results = $this->getDoctrine()->getRepository('AppBundle:Semester_results')->findBy(array('semId' => $id));

        $students = $this->getDoctrine()->getRepository('AppBundle:Student')->findAll();
        $modules = $this->getDoctrine()->getRepository('AppBundle:Module')->findBy(array('semId' => $id));
        $moduleCodes = array();
        $moduleCredits = array();
        $moduleIsGpa = array();   //array to keep GPA/non-GPA
        foreach ($modules as $obj) {
           array_push($moduleCodes, $obj->getCode());
           $moduleCredits[$obj->getCode()] = $obj->getCredits();
           $moduleIsGpa[$obj->getCode()] = $obj->getGpa();
        }



        $gradeObjects = $this->getDoctrine()->getRepository('AppBundle:Grade')->findAll();
        $grades = array();
        foreach ($gradeObjects as $obj) {
            $grades[$obj->getGrade()] = $obj->getMark();

        }


        $em = $this->getDoctrine()->getManager();
        

        foreach ($students as $student) {
            $gs = $student->getGrades();

            $totalMarks = 0.0000;
            $totalCredits = 0.0;
            

            foreach ($gs as $g) {
                //echo $g->getMCode();
                $code = $g->getMCode();
                if(in_array($code, $moduleCodes) && $moduleIsGpa[$code])
                  {             
                    $totalMarks+=$grades[$g->getGrade()]*$moduleCredits[$code];
                    $totalCredits += $moduleCredits[$g->getMCode()];
                }
            }

            $result = $this->getDoctrine()->getRepository('AppBundle:Semester_results')->findOneBy(array('semId' => $id,'stuId'=>$student->getId()));
            if($result==null) 
                {
                    $result = new Semester_results();
                    $result->setSemId($id);
                    $result->setStuId($student->getId());

                }

            if($totalCredits>0)
                $result->setGPA($totalMarks/$totalCredits);
            else
                $result->setGPA(0);

            $result->setSemCredits($totalCredits);

            $em->persist($result);
            $em->flush();

        }

        $results = $this->getDoctrine()->getRepository('AppBundle:Semester_results')->findBy(array('semId' => $id), array('gPA' => 'DESC') );
        $rank = 1;
        $lastGpa = 5.0000;
        // set ranks 
        foreach ($results as $result) {
            if ($result->getGpa() == $lastGpa) {
                $rank--;
            }
            $result->setRank($rank);
            $rank++;
            $lastGpa = $result->getGpa();

            $em->persist($result);
            $em->flush();
           //echo $result->getStuId()."<br>";
        }

        //die();
        return $this->redirectToRoute('semester_home');
    }

    /**
     * @Route("/semester/view/{id}", name="semester_view")
     */
    public function viewAction($id, Request $request)
    {
        $semester =  Semester::getOne($id);
        $semResults = Semester_results::getAllSemester($id);
        return $this->render('semester/view.html.twig', array('semester' =>$semester, 'results' => $semResults));  
    }

    /**
     * @Route("/semester/view", name="semester_viewAll")
     */
    public function viewallAction( Request $request)
    {
        $semesters = Semester::getAll();
        $semResults = Semester_results::getAll();
        return $this->render('semester/viewall.html.twig', array('semesters' => $semesters, 'results' => $semResults));
    }
}



