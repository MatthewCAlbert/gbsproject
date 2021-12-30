<?php

class csv extends mysqli{

    private $state_csv = false;
    public function __construct(){
        parent::__construct('localhost','root','','gbsmoneydb');
        if ($this->connect_error){
            echo"Fail to connect to DB".$this->connect_error;
        }
    }
    public function import($file){
        global $target, $export, $filename;
        $file = fopen($file,'r');
        $export = array();
        $affected = 0;
        
        while($row=fgetcsv($file)){
            
            $value = "'".implode("','",$row)."'";
            //echo $value.'<br>';
            //echo something you wanna see? 

            //export
            $newdata = array(
                'name' => $row[2],
                'password' => $randomPw
            );
            //$export['name'][] = $row[2];
            //$export['password'][] = $randomPw;

            if( $target == 1 ){
                $sql = "INSERT INTO `transaction`(`machine_id`,`sender`,`receiver`,`type`,`value`,`description`,`status`,`time`) VALUES (".$value.")";
            }else if( $target == 2 ){
                $sql = "INSERT INTO `balance_history`(`id`,`balance`,`time`) VALUES (".$value.")";
            }
            //echo $sql;
            $res = mysqli_query($this,$sql);
            if($res){
                echo '<br>Log inserted!';
                $affected++;
            }
        }
        echo "<h3>Inserted ".$affected." logs!</h3>";
        $_SESSION['filename'] = $filename;
        $_SESSION['export'] = $export; //give export array to session

    }
    
}