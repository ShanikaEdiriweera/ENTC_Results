<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Controller\Connection;

/**
 * Grade
 *
 * @ORM\Table(name="grade")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GradeRepository")
 */
class Grade
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
     * @ORM\Column(name="grade", type="string", length=4, unique=true)
     */
    private $grade;

    /**
     * @var string
     *
     * @ORM\Column(name="mark", type="decimal", precision=2, scale=1, unique=false)
     */
    private $mark;


    public static function getOne($id)
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $grade = new Grade();
        $stmt = $con->prepare('SELECT `id`,`grade`,`mark` FROM grade WHERE id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($grade->id,$grade->grade,$grade->mark);
        $stmt->fetch();
        $stmt->close();
        return $grade;
    }
        
    public static function getAll()
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $grades = array(); //Make an empty array
        $stmt = $con->prepare('SELECT id,grade,mark FROM grade');
        $stmt->execute();
        $stmt->bind_result($id,$grd,$mark);
        while($stmt->fetch())
        {
            $grade = new Grade();
            $grade->id=$id;
            $grade->setGrade($grd);
            $grade->setMark($mark);
            array_push($grades,$grade); //Push one by one
        }
        $stmt->close();
        
        return $grades;
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
     * Set grade
     *
     * @param string $grade
     *
     * @return Grade
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
     * Set mark
     *
     * @param string $mark
     *
     * @return Grade
     */
    public function setMark($mark)
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * Get mark
     *
     * @return string
     */
    public function getMark()
    {
        return $this->mark;
    }
}

