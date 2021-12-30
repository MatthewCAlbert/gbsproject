<?php 
    //ASSIGN VARIABLES
    $ppg = 30; //query per page (default)
    $search_page_location = 'index.php'; //page query links
    $extra_param = '';
    $sql = "SELECT * FROM `transaction`";
    $target = 'all';


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

        $sql .= " WHERE `$type` ".$exact_or_not;
        
        if(isset($_GET['sort'])){
            $sort = mysqli_escape_string($conn,$_GET['sort']);
            $extra_param =  $extra_param.'&sort='.$sort;
            switch($sort){
                case '1' : $sort = 'ASC';break;
                case '2' : $sort = 'DESC';break;
            }
            $sql .= " ORDER BY `$type` $sort";
        }
    }