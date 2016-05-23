<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Controller\Connection;

/**
 * student_module_grade
 *
 * @ORM\Table(name="student_module_grade")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\student_module_gradeRepository")
 */
class student_module_grade
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="s_id", type="string", length=7)
     */
    private $sId;

    /**
     * @var string
     *
     * @ORM\Column(name="m_code", type="string", length=7)
     */
    private $mCode;

    /**
     * @var string
     *
     * @ORM\Column(name="grade", type="string", length=4)
     */
    private $grade;


    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="grades")
     * @ORM\JoinColumn(name="s_id", referencedColumnName="index_no")
     */
    private $student;

    //marks variable for take all marks as a string
    private $marks; 
    
    //Semester ID
    private $semId;
    //Semester ID
    private $mTitle;

    public function save()
    {
        $con = Connection::getConnectionObject()->getConnection();

        if($this->id ==null)//check whether the module code 
        {                       
            $stmt = $con->prepare('INSERT INTO `student_module_grade` (`s_id`,`m_code`,`grade`) VALUES (?,?,?)');  
            $stmt->bind_param("sss",$this->sId,$this->mCode,$this->grade);  
            $stmt->execute();  
            $stmt->close();
        }
        else
        {
            $stmt = $con->prepare('UPDATE student_module_grade SET s_id = ?,m_code = ?,grade = ?');  
            $stmt->bind_param("sss",$this->sId,$this->mCode,$this->grade);  
            $stmt->execute();  
            $stmt->close();   
        }

        $con->close();
    }

    public static function saveAll($module,$marks,$doc)
    {
        $con = Connection::getConnectionObject()->getConnection();

        //splitting the string from spreadsheet
        $arr = explode(" ",$marks);
        //$arr =preg_split('/\s+/', $marks);

        $stuId = "";
        $grd = "";
        $counter = 1;

        $em = $doc->getManager();

        foreach ($arr as $element){
            //arr has both ids and grades
            if($counter%2 == 1){
                $stuId = $element;

            }else{
                $grd = $element;

                //getting stu_mod_grd using doctrine

                $stu_mod_grd = $doc->getRepository('AppBundle:student_module_grade')->findOneBy(array('mCode' => $module,'sId'=>$stuId));
                //create new stu_mod_grd if not found
                if($stu_mod_grd==null) 
                {
                    $stu_mod_grd = new student_module_grade();
                    $stu_mod_grd->setMCode($module);
                    
                    $stu_mod_grd->setSId($stuId);
                }
                //adding grade
                $stu_mod_grd->setGrade($grd);
                //die($stu_mod_grd->sId);
                $em->persist($stu_mod_grd);
                $em->flush();

            }
            $counter++;
        }
        // if($this->id ==null)
        // {                       
        //     $stmt = $con->prepare('INSERT INTO `student_module_grade` (`s_id`,`m_code`,`grade`) VALUES (?,?,?)');  
        //     $stmt->bind_param("sss",$this->sId,$this->mCode,$this->grade);  
        //     $stmt->execute();  
        //     $stmt->close();
        // }
        // else
        // {
        //     $stmt = $con->prepare('UPDATE student_module_grade SET s_id = ?,m_code = ?,grade = ?');  
        //     $stmt->bind_param("sss",$this->sId,$this->mCode,$this->grade);  
        //     $stmt->execute();  
        //     $stmt->close();   
        // }

        $con->close();
    }

    
    //modify to get only the relevent module results
    public static function getModuleResults($mCode)
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $results = array(); //Make an empty array
        $stmt = $con->prepare('SELECT id,s_id,m_code,grade FROM student_module_grade');
        $stmt->execute();
        $stmt->bind_result($id,$sId,$mCode,$grade);
        while($stmt->fetch())
        {
            $result = new student_module_grade();
            $result->id=$id;
            $result->setSId($sId);
            $result->setMCode($mCode);
            $result->setGrade($grade);
            array_push($results,$result); //Push one by one
        }
        $stmt->close();
        
        return $results;
    }
    
    //method to get student's results with the semester
    public static function getStudentModuleResults($stuId)
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $results = array(); //Make an empty array
        $stmt = $con->prepare('SELECT smg.id, smg.s_id, smg.m_code, m.title, m.sem_id, smg.grade FROM student_module_grade smg INNER JOIN module m ON smg.m_code = m.code INNER JOIN student s ON smg.s_id = s.index_no WHERE s.id = ?');
        $stmt->bind_param("s",$stuId);
        $stmt->execute();
        $stmt->bind_result($id,$sId,$mCode,$title,$sem,$grade);
        while($stmt->fetch())
        {
            $result = new student_module_grade();
            $result->id=$id;
            $result->setSId($sId);
            $result->setMCode($mCode);
            $result->mTitle=$title;
            $result->setSemId($sem);
            $result->setGrade($grade);
            array_push($results,$result); //Push one by one
        }
        $stmt->close();
        
        return $results;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set sId
     *
     * @param string $sId
     *
     * @return student_module_grade
     */
    public function setSId($sId)
    {
        $this->sId = $sId;

        return $this;
    }

    /**
     * Get sId
     *
     * @return string
     */
    public function getSId()
    {
        return $this->sId;
    }

    /**
     * Set mCode
     *
     * @param string $mCode
     *
     * @return student_module_grade
     */
    public function setMCode($mCode)
    {
        $this->mCode = $mCode;

        return $this;
    }

    /**
     * Get mCode
     *
     * @return string
     */
    public function getMCode()
    {
        return $this->mCode;
    }

    /**
     * Set grade
     *
     * @param string $grade
     *
     * @return student_module_grade
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return string
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set student
     *
     * @param \AppBundle\Entity\Student $student
     *
     * @return student_module_grade
     */
    public function setStudent(\AppBundle\Entity\Student $student = null)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \AppBundle\Entity\Student
     */
    public function getStudent()
    {
        return $this->student;
    }

    //getters setters for marks
    public function setMarks($marks)
    {
        $this->marks = $marks;

        return $this;
    }

    public function getMarks()
    {
        return $this->marks;
    }
    
    //getters setters for semId
    public function setSemId($sem)
    {
        $this->semId = $sem;

        return $this;
    }

    public function getSemId()
    {
        return $this->semId;
    }
    
    //getters setters for mTitle
    public function setMTitle($title)
    {
        $this->mTitle = $title;

        return $this;
    }

    public function getMTitle()
    {
        return $this->mTitle;
    }
}
