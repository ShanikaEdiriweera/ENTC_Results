<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Controller\Connection;

/**
 * Semester
 *
 * @ORM\Table(name="semester")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SemesterRepository")
 */
class Semester
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
     * @ORM\Column(name="name", type="string", length=10, unique=true)
     */
    private $name;


    public static function getOne($id)
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $semester = new Semester();
        $stmt = $con->prepare('SELECT `id`,`name` FROM semester WHERE id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($semester->id,$semester->name);
        $stmt->fetch();
        $stmt->close();
        return $semester;
    }
        
    public static function getAll()
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $semesters = array(); //Make an empty array
        $stmt = $con->prepare('SELECT id,name FROM semester');
        $stmt->execute();
        $stmt->bind_result($id,$name);
        while($stmt->fetch())
        {
            $semester = new Semester();
            $semester->id=$id;
            $semester->setName($name);
            array_push($semesters,$semester); //Push one by one
        }
        $stmt->close();
        
        return $semesters;
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
     * @return Semester
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
}

