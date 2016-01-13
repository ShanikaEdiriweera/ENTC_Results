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
}

