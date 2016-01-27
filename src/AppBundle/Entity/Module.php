<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Controller\Connection;

/**
 * Module
 *
 * @ORM\Table(name="module")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModuleRepository")
 */
class Module
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
     * @ORM\Column(name="code", type="string", length=7, unique=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=50)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="credits", type="decimal", precision=2, scale=1)
     */
    private $credits;

    /**
     * @var bool
     *
     * @ORM\Column(name="gpa", type="boolean")
     */
    private $gpa;

    /**
     * @var integer
     *
     * @ORM\Column(name="sem_id", type="integer")
     */
    private $semId;


    public function save()
    {
        $con = Connection::getConnectionObject()->getConnection();

        if($this->id ==null)
        {                       
            $stmt = $con->prepare('INSERT INTO `module` (`code`,`title`,`sem_id`,`credits`,`gpa`) VALUES (?,?,?,?,?)');  
            $stmt->bind_param("ssids",$this->code,$this->title,$this->semId,$this->credits,$this->gpa);  
            $stmt->execute();  
            $stmt->close();
        }
        else
        {
            $stmt = $con->prepare('UPDATE module SET (`code`,`title`,`sem_id`,`credits`,`gpa`) VALUES (?,?,?,?,?)');  
            $stmt->bind_param("ssids",$this->code,$this->title,$this->semId,$this->credits,$this->gpa);  
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

        $module = new Module();
        $stmt = $con->prepare('SELECT `id`,`code`,`title`,`sem_id`,`credits`,`gpa` FROM module WHERE id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($module->id,$module->code,$module->title,$module->semId,$module->credits,$module->gpa);
        $stmt->fetch();
        $stmt->close();
        return $module;
    }
        
    public static function getAll()
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $modules = array(); //Make an empty array
        $stmt = $con->prepare('SELECT id,code,title,sem_id,credits,gpa FROM module');
        $stmt->execute();
        $stmt->bind_result($id,$code,$title,$semId,$credits,$gpa);
        while($stmt->fetch())
        {
            $module = new Module();
            $module->id=$id;
            $module->setTitle($title);
            $module->setCode($code);
            $module->setSemId($semId);
            $module->setCredits($credits);
            $module->setGpa($gpa);
            array_push($modules,$module); //Push one by one
        }
        $stmt->close();
        
        return $modules;
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
     * Set code
     *
     * @param string $code
     *
     * @return Module
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Module
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set credits
     *
     * @param integer $credits
     *
     * @return Module
     */
    public function setCredits($credits)
    {
        $this->credits = $credits;

        return $this;
    }

    /**
     * Get credits
     *
     * @return int
     */
    public function getCredits()
    {
        return $this->credits;
    }

    /**
     * Set gpa
     *
     * @param boolean $gpa
     *
     * @return Module
     */
    public function setGpa($gpa)
    {
        $this->gpa = $gpa;

        return $this;
    }

    /**
     * Get gpa
     *
     * @return bool
     */
    public function getGpa()
    {
        return $this->gpa;
    }

    /**
     * Set semId
     *
     * @param integer $semId
     *
     * @return Module
     */
    public function setSemId($semId)
    {
        $this->semId = $semId;

        return $this;
    }

    /**
     * Get semId
     *
     * @return integer
     */
    public function getSemId()
    {
        return $this->semId;
    }
}
