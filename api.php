<?php

require_once("Rest.inc.php");

class API extends REST {

    public $data = "";
    //Enter details of your database
    const DB_SERVER = "localhost";
    const DB_USER = "root";
    const DB_PASSWORD = "";
    const DB = "groentego";

    private $db = NULL;

    public function __construct(){
        parent::__construct();              // Init parent contructor
        $this->dbConnect();                 // Initiate Database connection
    }

    public function dbConnect(){
        $this->db = mysqli_connect(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD,self::DB);

        $sql = "SELECT * FROM `cyberfarm`";
        $result = mysqli_query($this->db, $sql) or die("Error in Selecting " . mysqli_error($this->db));

        //create an array
        $emparray = array();
        while($row =mysqli_fetch_assoc($result))
        {
            $emparray[] = $row;
        }
        $this->GetCyberfarms($emparray);
    }

    /*
     * Public method for access api.
     * This method dynamically call the method based on the query string
     *
     */

    private function hello(){
        echo str_replace("this","that","Test");


    }


    public function GetCyberfarms($emparray){
        // Cross validation if the request method is GET else it will return "Not Acceptable" status
        if($this->get_request_method() != "GET"){
            $this->response('',406);
        }
       else{
           // If success everythig is good send header as "OK" return param
           header("Content-Type: application/json");
           $this->response(json_encode($emparray),200);
       }

    }
}

// Initiiate Library

$api = new API;
?>