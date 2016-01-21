<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Controller\Connection;

/**
 * Student
 *
 * @ORM\Table(name="student")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StudentRepository")
 */
class Student
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
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="index_no", type="string", length=7, unique=true)
     */
    private $indexNo;

    /**
     * @var string
     *
     * @ORM\Column(name="CGPA", type="decimal", precision=5, scale=4)
     */
    private $cGPA;

    /**
     * @var int
     *
     * @ORM\Column(name="rank", type="integer")
     */
    private $rank;


    public function save()
    {
    	$con = Connection::getConnectionObject()->getConnection();

        if($this->id ==null)
        {           	        
	        $stmt = $con->prepare('INSERT INTO `student` (`name`,`index_no`) VALUES (?,?)');  
	        $stmt->bind_param("ss",$this->name,$this->indexNo);  
	        $stmt->execute();  
	        $stmt->close();
        }
        else
        {
	        $stmt = $con->prepare('UPDATE student SET name =?,index_no=? WHERE id = ?');  
	        $stmt->bind_param("ssi",$this->name,$this->indexNo,$this->id);  
	        $stmt->execute();  
	        $stmt->close();   
        }

        $con->close();
    }

    public static function getOne($id)
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $student = new Student();
        $stmt = $con->prepare('SELECT id,name,index_no,CGPA,rank FROM student WHERE id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($student->id,$student->name,$student->indexNo,$student->cGPA,$student->rank);
        $stmt->fetch();
        $stmt->close();
        return $student;
    }
        
    public static function getAll()
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $students = array(); //Make an empty array
        $stmt = $con->prepare('SELECT id,name,index_no,CGPA,rank FROM student');
        $stmt->execute();
        $stmt->bind_result($id,$name,$indexNo,$cGPA,$rank);
        while($stmt->fetch())
        {
            $student = new Student();
            $student->id=$id;
            $student->setName($name);
            $student->setIndexNo($indexNo);
            $student->setCGPA($cGPA);
            $student->setRank($rank);
            array_push($students,$student); //Push one by one
        }
        $stmt->close();
        
        return $students;
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
     * Set name
     *
     * @param string $name
     *
     * @return Student
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set indexNo
     *
     * @param string $indexNo
     *
     * @return Student
     */
    public function setIndexNo($indexNo)
    {
        $this->indexNo = $indexNo;

        return $this;
    }

    /**
     * Get indexNo
     *
     * @return string
     */
    public function getIndexNo()
    {
        return $this->indexNo;
    }

    /**
     * Set cGPA
     *
     * @param string $cGPA
     *
     * @return Student
     */
    public function setCGPA($cGPA)
    {
        $this->cGPA = $cGPA;

        return $this;
    }

    /**
     * Get cGPA
     *
     * @return string
     */
    public function getCGPA()
    {
        return $this->cGPA;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     *
     * @return Student
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
}

