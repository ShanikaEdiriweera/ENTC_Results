<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Controller\Connection;

/**
 * Semester_results
 *
 * @ORM\Table(name="semester_results")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Semester_resultsRepository")
 */
class Semester_results
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
     * @var int
     *
     * @ORM\Column(name="sem_id", type="integer")
     */
    private $semId;

    /**
     * @var int
     *
     * @ORM\Column(name="stu_id", type="integer")
     */
    private $stuId;

    /**
     * @var string
     *
     * @ORM\Column(name="GPA", type="decimal", precision=5, scale=4, nullable=true)
     */
    private $gPA;

    /**
     * @var int
     *
     * @ORM\Column(name="rank", type="integer", nullable=true)
     */
    private $rank;

    private $studentName;
    private $studentIndex;


    public function save()
    {
        $con = Connection::getConnectionObject()->getConnection();

        if($this->id ==null)
        {                       
            $stmt = $con->prepare('INSERT INTO `semester_results` (`sem_id`,`stu_id`,`GPA`,`rank`) VALUES (?,?,?,?)');  
            $stmt->bind_param("iisi",$this->semId,$this->stuId,$this->gPA,$this->rank);  
            $stmt->execute();  
            $stmt->close();
        }
        else
        {
            $stmt = $con->prepare('UPDATE `semester_results` (`sem_id`,`stu_id`,`GPA`,`rank`) VALUES (?,?,?,?) WHERE id = ?');  
            $stmt->bind_param("iisii",$this->semId,$this->stuId,$this->gPA,$this->rank,$this->id);  
            $stmt->execute();  
            $stmt->close();   
        }

        $con->close();
    }

    public static function updateGpa($semester_id)
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $results = Semester_results::getAllSemester($semester_id); //Make an empty array


        foreach($results as $result){
            //vars for calculate gpa
            $totalMark = 0.0000;
            $totalCredits = 0.0;

            //query to get the marks and credits
            $stmt = $con->prepare('SELECT module.credits,grade.mark FROM module,student_module_grade,grade,student WHERE module.code = student_module_grade.m_code AND student_module_grade.grade = grade.grade AND student_module_grade.s_id = student.index_no AND module.gpa = true AND student.id = ? AND module.sem_id = ?');
            $stmt->bind_param("ss",$result->stuId,$semester_id);
            $stmt->execute();

            $stmt->bind_result($credits,$mark);
            while($stmt->fetch())
            {
                $totalMark += $mark;
                $totalCredits += $credits;
            }    

            //adding the gpa to the result object
            $result->gPA = $totalMark / $totalCredits;
        }
        
        return $results;
    }

    public static function getOne($id)
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $result = new Semester_results();
        $stmt = $con->prepare('SELECT id,sem_id,stu_id,GPA,rank FROM semester_results WHERE id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($result->id,$result->semId,$result->stuId,$result->gPA,$result->rank);
        $stmt->fetch();
        $stmt->close();
        return $result;
    }
        
    public static function getAll()
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $results = array(); //Make an empty array
        $stmt = $con->prepare('SELECT id,sem_id,stu_id,GPA,rank FROM semester_results');
        $stmt->execute();
        $stmt->bind_result($id,$semId,$stuId,$gPA,$rank);
        while($stmt->fetch())
        {
            $result = new Semester_results();
            $result->id=$id;
            $result->setSemId($semId);
            $result->setStuId($stuId);
            $result->setGPA($gPA);
            $result->setRank($rank);
            array_push($results,$result); //Push one by one
        }
        $stmt->close();
        
        return $results;
    }

    public static function getAllSemester($semester_id)
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $results = array(); //Make an empty array
        // $stmt = $con->prepare('SELECT id,sem_id,stu_id,GPA,rank,name,index_no FROM semester_results INNER JOIN student ON semester_results.stu_id = student.id WHERE sem_id = ?');
        //$stmt = $con->prepare('SELECT id,sem_id,stu_id,GPA,rank,name,index_no FROM semester_results,student WHERE semester_results.stu_id = student.id AND sem_id = ?');
        $stmt = $con->prepare('SELECT id,sem_id,stu_id,GPA,rank FROM semester_results WHERE sem_id = ?');
        $stmt->bind_param("s",$semester_id);
        $stmt->execute();

        //$stmt->bind_result($id,$semId,$stuId,$gPA,$rank,$name,$index);
        $stmt->bind_result($id,$semId,$stuId,$gPA,$rank);
        while($stmt->fetch())
        {
            $result = new Semester_results();
            $result->id=$id;
            $result->setSemId($semId);
            $result->setStuId($stuId);
            $result->setGPA($gPA);
            $result->setRank($rank);
            //$result->setStudentName($name);
            //$result->setStudentIndex($index);
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
     * Set semId
     *
     * @param integer $semId
     *
     * @return Semester_results
     */
    public function setSemId($semId)
    {
        $this->semId = $semId;

        return $this;
    }

    /**
     * Get semId
     *
     * @return int
     */
    public function getSemId()
    {
        return $this->semId;
    }

    /**
     * Set stuId
     *
     * @param integer $stuId
     *
     * @return Semester_results
     */
    public function setStuId($stuId)
    {
        $this->stuId = $stuId;

        return $this;
    }

    /**
     * Get stuId
     *
     * @return int
     */
    public function getStuId()
    {
        return $this->stuId;
    }

    /**
     * Set gPA
     *
     * @param string $gPA
     *
     * @return Semester_results
     */
    public function setGPA($gPA)
    {
        $this->gPA = $gPA;

        return $this;
    }

    /**
     * Get gPA
     *
     * @return string
     */
    public function getGPA()
    {
        return $this->gPA;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     *
     * @return Semester_results
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return int
     */
    public function getRank()
    {
        return $this->rank;
    }


    public function setStudentName($name)
    {
        $this->studentName = $name;

        return $this;
    }

    public function getStudentName()
    {
        return $this->studentName;
    }

    public function setStudentIndex($index)
    {
        $this->studentIndex = $index;

        return $this;
    }

    public function getStudentIndex()
    {
        return $this->studentIndex;
    }
}

