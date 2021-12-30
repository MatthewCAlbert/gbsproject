<?php 
    //ASSIGN VARIABLES
    $ppg = 30; //query per page (default)
    $search_page_location = 'index.php'; //page query links
    $extra_param = '';
    $sql = "SELECT * FROM `help`";


    //Looking for extra parameter
    if(isset($_GET['q'])&&isset($_GET['by'])){
        $search = $_GET['q'];

        //set $extra_param
        $extra_param = '&q='.$search;
        if(isset($_GET['by'])){
            $type = $_GET['by'];
            $extra_param =  $extra_param.'&by='.$_GET['by'];
        }
        
        if(isset($_GET['status'])){
            $status = $_GET['status'];
            $extra_param =  $extra_param.'&status='.$_GET['status'];
        }

        //If user wants to change Query per Page
        if(isset($_GET['per-page'])){
            $ppg = $_GET['per-page'];
            $extra_param =  $extra_param.'&per-page='.$_GET['per-page'];
        }

        //determine exact search or not 
        if( isset($_GET['exact']) ){
            $extra_param =  $extra_param.'&exact';
            $exact_or_not = "= '$search' ";
        }else{
            $exact_or_not = " LIKE '%$search%'";
        }

        $sql .= " WHERE `$type` ".$exact_or_not;
        $sql .= " ORDER BY `id` DESC ";
    }