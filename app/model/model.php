<?php

class Model {
    private $connection;

    public function connect(){
        $server="http://sandbox2.ufps.edu.co/phpmyadmin/index.php";
        $user="1151224";
        $pass="1151224";
        $bd="1151224";
        $this->connection = mysqli_connect($server,$user,$pass,$bd) or  die(("Error " . mysqli_error($this->connection)));
    }

    public function query($sql){
        return mysqli_query($this->connection,$sql);
    }


    public function terminate(){
        mysqli_close($this->connection);
    }

}

?>