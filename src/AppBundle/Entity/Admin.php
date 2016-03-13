<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Controller\Connection;

use Symfony\Component\Security\Core\User\UserInterface;


/**
 * Admin
 *
 * @ORM\Table(name="admin")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdminRepository")
 */
class Admin implements UserInterface, \Serializable
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
     * @ORM\Column(name="username", type="string", length=15, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=30, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password_hash", type="string", length=50)
     */
    private $passwordHash;

    /**
    * @ORM\Column(name="is_active", type="string")
    */
    private $isActive;


    //------------------For authentication purpose-----------------------------------------------
    public function __construct()
    {
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid(null, true));
    }
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getRoles()
    {
        return array('ROLE_ADMIN');
    }

    public function eraseCredentials()
    {

    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->passwordHash,
            $this->name,
            $this->email,

            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->passwordHash,
            $this->name,
            $this->email,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }
    //-------------------------------------------------------------------------
    
    //---------------------validate function ------------------------under construction
    private $errorMessage;
    
    public function getError(){ return $this->errorMessage;}

    public function validate()
    {
        $this->errorMessage = "";
        //if ( ( (!preg_match("/([\d]{10})/", $this->contactNu)) && strlen($this->contactNu)!=10 ) )
        //    $this->errorMessage = "Contact Number is not valid";

        $admins = Admin::getAll();
        $userNames = array();
        foreach ($admins as $ad){
            array_push($userNames,$ad->getUserName());
        }

        if (in_array($this->username,$userNames)) $this->errorMessage= 'username already assigned';
 
        //if (  strlen($this->password)<6 )
        //    $this->errorMessage = "Password must be atleast 6 characters long";

       
        /*    $bloodTypes = array('A+','A-','B+', 'B-', 'AB+', 'AB-', 'O+', 'O-');
        if(!in_array($this->bloodType, $bloodTypes))
            $this->errorMessage = 'Blood Type is not valid'; */

        //Return true if error message is "" (no eror)
        //Else return false
        return $this->errorMessage == "";
    }
    //-----------------------------------------------------------   

    public static function getOne($id){

        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $ad = new Admin();
        $ad->id = $id;

        $stmt = $con->prepare('SELECT name,,username,password_hash,email,is_active FROM admin WHERE id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($ad->name, $ad->username, $ad->passwordHash, $ad->email,$ad->isActive);
        $stmt->fetch();
        $stmt->close();
        return $ad;
    }

    public static function getAll(){
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $stmt = $con->prepare('SELECT id,name,username,password_hash,email,is_active FROM admin');
        
        $admins = array();

        if ($stmt->execute()) {
            $stmt->bind_result($id,$name,$username,$passwordHash,$email,$isActive);
            
            while ( $stmt->fetch() ) {
                $ad = new Admin();
                $ad->id = $id;
                $ad->name = $name;
                $ad->username = $username;
                $ad->passwordHash = $passwordHash;
                $ad->email = $email;
                $ad->isActive = $isActive;
                $admins[] = $ad;
            }
            $stmt->close();
            
            return $admins;  
        }
        $stmt->close();
        return false;     
    }


    public function save()
    {
        $con = Connection::getConnectionObject()->getConnection();

        if($this->id ==null)
        {                       
            $stmt = $con->prepare('INSERT INTO `admin` (`name`,`username`,`email`,`password_hash`,`is_active`) VALUES (?,?,?,?,?)');  
            $stmt->bind_param("sssss",$this->name,$this->username,$this->email,$this->passwordHash,$this->isActive);  
            $stmt->execute();  
            $stmt->close();
        }
        else
        {
            $stmt = $con->prepare('UPDATE admin SET name =?,username=?,email =?,password_hash=?,is_active=? WHERE id = ?');  
            $stmt->bind_param("sssssi",$this->name,$this->username,$this->email,$this-> passwordHash,$this->id,$this->isActive);  
            $stmt->execute();  
            $stmt->close();   
        }

        $con->close();
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
     * @return Admin
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
     * Set username
     *
     * @param string $username
     *
     * @return Admin
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Admin
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set passwordHash
     *
     * @param string $passwordHash
     *
     * @return Admin
     */
    public function setPasswordHash($passwordHash)
    {
        $this->passwordHash = $passwordHash;

        return $this;
    }

    /**
     * Get passwordHash
     *
     * @return string
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    public function getPassword()
    {
        return $this->passwordHash;
    }

    //The value which will be save is 1.. but we access as true or false;
    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return ($this->isActive=='1');
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive)
    {
        if($isActive)
            $this->isActive = 1;
        else
            $this->isActive = 0;
    }
}




