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


    // public function save()
    // {
    // 	$con = Connection::getConnectionObject()->getConnection();

    //     if($this->id ==null)
    //     {           	        
	   //      $stmt = $con->prepare('INSERT INTO `player` (`name`,`index_number`, `date_of_birth`, `year`, `department_id`, `address`, `blood_type`) VALUES (?,?,   ?,?,?,?,?)');  
	   //      $stmt->bind_param("sssiiss",$this->name,$this->indexNumber,$this->dateOfBirth,$this->year,$this->departmentId,$this->address,$this->bloodType);  
	   //      $stmt->execute();  
	   //      $stmt->close();
    //     }
    //     else
    //     {
	   //      $stmt = $con->prepare('UPDATE player SET name =?,index_number=?,date_of_birth=?,year=?,department_id=?,address=?,blood_type=? WHERE player.id = id');  
	   //      $stmt->bind_param("sssiiss",$this->name,$this->indexNumber,$this->dateOfBirth,$this->year,$this->departmentId,$this->address,$this->bloodType);  
	   //      $stmt->execute();  
	   //      $stmt->close();   
    //     }

    //     $con->close();
    // }

    // public static function getOne($id)
    // {
    //     $con = Connection::getConnectionObject()->getConnection();
    //     // Check connection
    //     if (mysqli_connect_errno())
    //     {
    //         echo "Failed to connect to MySQL: " . mysqli_connect_error();
    //     }

    //     $player = new Player();
    //     $stmt = $con->prepare('SELECT id,name,index_number,year,date_of_birth,address,blood_type,department_id FROM player WHERE id=?');
    //     $stmt->bind_param("s",$id);
    //     $stmt->execute();

    //     $stmt->bind_result($player->id,$player->name,$player->index_number,$player->year,$player->date_of_birth,$player->address,$player->blood_type,$player->department_id);
    //     $stmt->fetch();
    //     $stmt->close();
    //     return $player;
    // }
    //     public static function getAll()
    // {
    //     $con = Connection::getConnectionObject()->getConnection();
    //     // Check connection
    //     if (mysqli_connect_errno())
    //     {
    //         echo "Failed to connect to MySQL: " . mysqli_connect_error();
    //     }

    //      $players = array(); //Make an empty array
    //     $stmt = $con->prepare('SELECT id,name,index_number,year,date_of_birth,address,blood_type,department_id FROM player');
    //     $stmt->execute();
    //     $stmt->bind_result($id,$name,$indexNumber,$year,$dateOfBirth,$address,$bloodType,$departmentId);
    //     while($stmt->fetch())
    //     {
    //         $player = new Player();
    //         $player->id=$id;
    //         $player->setName($name);
    //         $player->setIndexNumber($indexNumber);
    //         $player->setYear($year);
    //         $player->setDateOfBirth($dateOfBirth);
    //         $player->setAddress($address);
    //         $player->setBloodType($bloodType);
    //         $player->setDepartmentId($departmentId);

    //         array_push($players,$player); //Push one by one
    //     }
    //     $stmt->close();
        
    //     return $players;

    // }

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

