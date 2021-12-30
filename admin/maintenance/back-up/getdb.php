<?php
    require '../../include/servercred.php';
    //ENTER THE RELEVANT INFO BELOW
    $mysqlUserName      = $username;
    $mysqlPassword      = $password;
    $mysqlHostName      = $servername;
    $DbName             = $dbname;
    $tables             = array("student","teacher","vendor","admin","transaction","help","api","balance_history,veritrans");

    if(isset($_POST['submit'])){
        $name = 'gbsemoney-backup';
        if( isset($_POST['name']) ){ $name = $_POST['name']; }
        date_default_timezone_set("Asia/Jakarta");
        $now_date = getdate();
        $date = $now_date['year']."-".getZero($now_date['mon'])."-".getZero($now_date['mday'])."-".getZero($now_date['hours'])."".getZero($now_date['minutes'])."".getZero($now_date['seconds']); 
        
        if( isset($_POST['date']) ){
            $backup_name = "$name-$date";
        }else{
            $backup_name = "$name";
        }


        Export_Database($mysqlHostName,$mysqlUserName,$mysqlPassword,$DbName,  $tables=false, $backup_name );
    }else{
        header("Location: ../back-up");
        exit();
    }
    
    function getZero($x){
        if( $x > 9 ){
            return $x;
        }else{
            return '0'.$x;
        }
    }
   
    //or add 5th parameter(array) of specific tables:    array("mytable1","mytable2","mytable3") for multiple tables
    function Export_Database($host,$user,$pass,$name,  $tables=false, $backup_name )
    {
        $mysqli = new mysqli($host,$user,$pass,$name); 
        $mysqli->select_db($name); 
        $mysqli->query("SET NAMES 'utf8'");

        $queryTables    = $mysqli->query('SHOW TABLES'); 
        while($row = $queryTables->fetch_row()) 
        { 
            $target_tables[] = $row[0]; 
        }   
        if($tables !== false) 
        { 
            $target_tables = array_intersect( $target_tables, $tables); 
        }
        foreach($target_tables as $table)
        {
            $result         =   $mysqli->query('SELECT * FROM '.$table);  
            $fields_amount  =   $result->field_count;  
            $rows_num=$mysqli->affected_rows;     
            $res            =   $mysqli->query('SHOW CREATE TABLE '.$table); 
            $TableMLine     =   $res->fetch_row();
            $content        = (!isset($content) ?  '' : $content) . "\n\n".$TableMLine[1].";\n\n";

            for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) 
            {
                while($row = $result->fetch_row())  
                { //when started (and every after 100 command cycle):
                    if ($st_counter%100 == 0 || $st_counter == 0 )  
                    {
                            $content .= "\nINSERT INTO ".$table." VALUES";
                    }
                    $content .= "\n(";
                    for($j=0; $j<$fields_amount; $j++)  
                    { 
                        $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); 
                        if (isset($row[$j]))
                        {
                            $content .= '"'.$row[$j].'"' ; 
                        }
                        else 
                        {   
                            $content .= '""';
                        }     
                        if ($j<($fields_amount-1))
                        {
                                $content.= ',';
                        }      
                    }
                    $content .=")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) 
                    {   
                        $content .= ";";
                    } 
                    else 
                    {
                        $content .= ",";
                    } 
                    $st_counter=$st_counter+1;
                }
            } $content .="\n\n\n";
        }
        //$backup_name = $backup_name ? $backup_name : $name."___(".date('H-i-s')."_".date('d-m-Y').")__rand".rand(1,11111111).".sql";
        //$backup_name = $backup_name ? $backup_name : $name.".sql";
        $backup_name .= '.sql';
        header('Content-Type: application/octet-stream');   
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
        echo $content; exit;
    }
