<?php

namespace AppBundle\Controller;

use mysqli;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Singleton class
 *
 */
final class Connection extends Controller
{
    private $con;
        static $conn = null ;
    
    public static function getConnectionObject()
    {
        if (self::$conn === null) { //self === Connection
            Connection::$conn = new Connection();
        }
        return  Connection::$conn;
    }


    private function __construct()
    {
        // $con = $entity_manager->getConnection() ;
        // $username    = $con->getUsername();
        // $password = $con->getPassword();
        // $servername    = $con->getHost();
        // $dbname     = $con->getDatabase();

        $servername = "localhost";
        $username = "root";
        $password = null;
        $dbname = "ENTC_Results";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        else{
            //echo "connection created <br>";
            $this->con=$conn;
        }
    }
    
    public function getConnection(){
        return $this->con;
    }

    private function parseDsn ($dsn)
    {
      $dsnArray            = array();
      $dsnArray['phptype'] = substr($dsn, 0, strpos($dsn, ':'));
      preg_match('/dbname  = (\w+)/', $dsn, $dbname);
      $dsnArray['dbname']  = $dbname[1];
      preg_match('/host    = (\w+)/', $dsn, $host);
      $dsnArray['host']    = $host[1];

      return $dsnArray;
    }

}
?>