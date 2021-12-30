<?php
class csv extends mysqli{

    private $state_csv = false;
    public function __construct(){
        global $servername,$username,$password,$dbname;
        parent::__construct($servername,$username,$password,$dbname);
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

            $randomPw = base64_encode(random_bytes(8));
            echo '<p>Name: '.$row[2].' ('.$row[0].')</p>';
            echo '<p>Password: '.$randomPw.'</p>';
            echo '<div class="hr" style="height:3px;"></div>';

            //export
            $newdata = array(
                'name' => $row[2],
                'password' => $randomPw
            );
            //$export['name'][] = $row[2];
            //$export['password'][] = $randomPw;

            $hashedPw = password_hash("$randomPw",PASSWORD_BCRYPT);
            $hashedPw = "'".$hashedPw."'";
            $q = "INSERT INTO `$target`(`id`,`card_id`,`name`,`password`,`status`,`balance`) VALUES (".$value.",".$hashedPw.","."'active','0')";
            //echo $q;

            //check for same id or card_id
            $id=$row[0];
            $card_id=$row[1];
            //echo "<p>Checked component: ".$id.", ".$card_id."</p>";
            ///*
            //ADD JOIN CHECKER
            $sql = "SELECT `id`,`card_id` FROM `student` WHERE `id`='$id' OR `card_id`='$card_id' UNION
                    SELECT `id`,`card_id` FROM `teacher` WHERE `id`='$id' OR `card_id`='$card_id' UNION
                    SELECT `id`,`card_id` FROM `vendor` WHERE `id`='$id' OR `card_id`='$card_id'
            ";
            $res = mysqli_query($this,$sql);

            if( mysqli_num_rows($res) > 0 ){
                echo "Error duplicate on: ".$value;
            }else{
                $res_final = mysqli_query($this,$q);
                if( $res_final ){
                    array_push($export,$newdata);
                    $affected++;
                }else{
                    echo $this->error;
                }
            }
            //*/
        }
        echo "<h3>Inserted ".$affected." data!</h3>";
        $_SESSION['filename'] = $filename;
        $_SESSION['export'] = $export; //give export array to session

    }
    
}