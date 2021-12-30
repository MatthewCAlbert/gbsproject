<?php 
    //ASSIGN VARIABLES
    $ppg = 30; //query per page (default)
    $search_page_location = 'index.php'; //page query links
    $extra_param = '';
    $sql = '';
    $target = 'all';

    $tables = array();
    $tables1 = array();
    $tables2 = array();
    
    if(isset($_GET['target'])){
        $target = mysqli_real_escape_string($conn, $_GET['target']);
    }
    if($target == 'all'){
        array_push($tables,"SELECT * FROM `student`"); 
        array_push($tables,"SELECT * FROM `teacher`");  
        array_push($tables,"SELECT * FROM `vendor`");
        array_push($tables1,"SELECT * FROM `student`"); 
        array_push($tables1,"SELECT * FROM `teacher`");  
        array_push($tables1,"SELECT * FROM `vendor`");
        array_push($tables2,"Student"); 
        array_push($tables2,"Teacher");  
        array_push($tables2,"Vendor");
    }else{
        array_push($tables,"SELECT * FROM `$target`");
        array_push($tables1,"SELECT * FROM `$target`");
        $target_up = ucfirst($target);
        array_push($tables2,"$target_up");
    }

    //Looking for extra parameter
    if(isset($_GET['q'])&&isset($_GET['by'])){
        $search = mysqli_escape_string($conn,$_GET['q']);

        //set $extra_param
        $extra_param = '&q='.$search;
        if(isset($_GET['by'])){
            $type = mysqli_escape_string($conn,$_GET['by']);
            $extra_param =  $extra_param.'&by='.$type;
        }

        //If user wants to change Query per Page
        if(isset($_GET['per-page'])){
            $ppg = mysqli_escape_string($conn,$_GET['per-page']);
            $extra_param =  $extra_param.'&per-page='.$ppg;
        }

        //determine exact search or not 
        if( isset($_GET['exact']) ){
            $extra_param =  $extra_param.'&exact';
            $exact_or_not = "= '$search' ";
        }else{
            $exact_or_not = " LIKE '%$search%'";
        }

        for( $i = 0; $i < count($tables) ; $i ++ ){
            $tables[$i] = $tables[$i] . " WHERE `$type`".$exact_or_not;
        }

    }
    for( $i = 0; $i < count($tables) ; $i ++ ){
        if( $i < (count($tables)-1)  ){
            $sql = $sql . $tables[$i] . " UNION ";
        }else{
            $sql = $sql . $tables[$i];
        }
    }
    
    if(isset($_GET['sort'])){
        $sort = mysqli_escape_string($conn,$_GET['sort']);
        $extra_param =  $extra_param.'&sort='.$sort;
        switch($sort){
            case '1' : $sort = 'ASC';break;
            case '2' : $sort = 'DESC';break;
        }
        $sql .= " ORDER BY `$type` $sort";
    }

    
    function checkWho($x){
        global $tables1, $tables2, $conn;
        $y = 'none';
        for( $i = 0; $i < count($tables1) ; $i ++ ){
            $sql = $tables1[$i]." WHERE `id`= '$x'";
            //echo $sql.'<br>';
            $res = $conn->query($sql);
            if( $res->num_rows > 0 ){
                $y = $tables2[$i];
            }
        }
        return $y;
    }