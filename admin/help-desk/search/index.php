<?php
require "../../include/structure.php";
require '../../include/server.php';
require '../../include/session.checker.php';
require '../../include/getuserdata.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    require '../../include/structure/header.php'; 
    require 'search.php';
    ?>
    <title>Help Desk Search - GBS eMoney Admin</title>
    <?php require '../../include/structure/script.php'; ?>
    <script>
        $(document).ready(function(){
            $(".nav .nav-item:contains('Help Desk')").addClass('active');
        });
    </script>
</head>

<body class="">
    <div class="wrapper">
        <div class="sidebar" data-color="purple" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
            <?php require "../../include/structure/sidenav-bar.php"; ?>
        </div>
        <div class="main-panel">
            <?php require "../../include/structure/navbar.php"; ?>
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-chart card-header-success">
                                <h4 class="card-title">Message Search</h4>
                                <p class="card-category">Help Desk</p>
                            </div>
                            <div class="card-body">
                            <form class="card-category" method="get" action="<?php echo $search_page_location ?>">
                                <div class="row">
                                    <input type="hidden" name="page" value="1" hidden>
                                    <div class="col-7">
                                    <input type="text" name="q" class="form-control" placeholder="Search..." value="<?php if(isset($_GET['q'])){ echo $search;} ?>">
                                    </div>
                                    <div class="col">
                                        <select name="by" id="filter-sc" onclick="switchFilterOption()" class="form-control">
                                            <option value="id">ID</option>
                                            <option value="type" selected>Type</option>
                                            <option value="title">Title</option>
                                            <option value="description">Description</option>
                                            <option value="account_id">Account ID</option>
                                            <option value="email">Email</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select name="status" id="filter-sc-2" onclick="switchFilterOption()" class="form-control">
                                            <option value="all">All</option>
                                            <option value="unread">Unread</option>
                                            <option value="replied">Replied</option>
                                            <option value="solved">Solved</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="exact" <?php if(isset($_GET['exact'])){echo 'checked';} ?>> Whole
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                    <input type="number" name="per-page" class="form-control" title="Result per page" value="<?php if(isset($_GET['per-page'])){ echo $_GET['per-page'];}else{ echo $ppg; } ?>">
                                    </div>
                                    <div class="col">
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                            </div>
                            <div class="card-footer">
                                <div class="table-responsive">
                                <?php 
                                    //Counting for Pagination (Must be placed before adding LIMIT or generating buttons)
                                    //echo $sql;
                                    $res = $conn->query($sql);
                                    $countres = mysqli_num_rows($res);
                                    $pages = ceil($countres/$ppg); //Round UP the decimal
                                    if(isset($_GET['page'])){
                                        $selectedpage = $_GET['page'];
                                    }else{
                                        $selectedpage = 1;
                                    }

                                    //debugging area
                                    //echo '<h4>Available Query:'.$countres.'</h4>';
                                    //echo '<h4>Pages:'.$pages.'</h4>';
                                    
                                    //change queries with LIMIT
                                    //$countres => total query
                                    $start = ($selectedpage-1)*$ppg;
                                    //LIMIT (x,y) -> x( start from (0) ) + y(how many query)
                                    $sql = $sql."LIMIT $start,$ppg"; 
                                    $res = $conn->query($sql);

                                    //VERIFY selectedpage
                                    if( $selectedpage >= 1 && $selectedpage <= $pages ){
                                        $selectedpage_verified = true;
                                    }else{
                                        $selectedpage_verified = false;
                                    }

                                    //Generate Result
                                    if($selectedpage_verified == true){
                                        if( mysqli_num_rows($res) > 0 ){
                                            echo '
                                            <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th>Type</th>
                                                    <th>User ID</th>
                                                    <th>Email</th>
                                                    <th>Status</th>
                                                    <th class="text-right">Title</th>
                                                    <th class="text-right">Time</th>
                                                    <th class="text-center">View</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                            while($row = mysqli_fetch_array($res)){
                                                $edit_link = "'view.php?id=".$row['id']."'";
                                                $edit_icon = '';
                                                if( $user_row['level'] >=1 && $user_row['level'] != 3 ){
                                                    $edit_icon = '
                                                    <td class="td-actions text-center">
                                                        <button type="button" rel="tooltip" class="btn btn-info" onclick="href('.$edit_link.');">
                                                            <i class="far fa-eye"></i>
                                                        </button>
                                                    </td>';
                                                }
                                                switch($row['status']){
                                                    case 'unread' : $status = '<span class="text-rose">'.$row['status'].'</span>';break;
                                                    case 'replied' : $status = '<span class="text-warning">'.$row['status'].'</span>';break;
                                                    case 'solved' : $status = '<span class="text-success">'.$row['status'].'</span>';break;
                                                    default : $status = '<span class="text-warning">'.$row['status'].'</span>';break;
                                                }
                                                echo '
                                                <tr>
                                                    <td class="text-center">'.$row['id'].'</td>
                                                    <td>'.$row['type'].'</td>
                                                    <td>'.$row['account_id'].'</td>
                                                    <td>'.$row['email'].'</td>
                                                    <td>'.$status.'</td>
                                                    <td class="text-right">'.$row['title'].'</td>
                                                    <td class="text-right">'.$row['time'].'</td>'
                                                    .$edit_icon.'
                                                </tr>'; 
                                            }
                                            echo '
                                            </tbody>
                                        </table>';
                                        }else{
                                            echo '<h5>No Result</h5>';
                                        }
                                    }else if( !isset($_GET['page']) ){
                                        echo '<h5>Undefined Pages</h5>';
                                    }else{
                                        echo '<h5>Such Pages doesn\'t exist</h5>';
                                    }
                                                                
                                ?>
                                </div>
                            </div>
                            
                            <div class="page-number text-center">
                                            <?php
                                            if( isset($_GET['page']) || $selectedpage_verified == true){
                                                //Generate Page Link Button
                                                if( $pages > 1 && $selectedpage > 2 ){
                                                    echo '<a href="'.$search_page_location.'?page=1'.$extra_param.'" class="btn btn-secondary waves-effect waves-dark">First</a> ';
                                                }
                                                if( $selectedpage != 1 && $pages > 1 && isset($_GET['page']) ){
                                                    echo '<a href="'.$search_page_location.'?page='.($selectedpage-1).$extra_param.'" class="btn btn-secondary"><i class="fas fa-chevron-left"></i> Prev</a> ';
                                                }
                                                for( $page=$selectedpage-2 ; $page<=$selectedpage+2 ; $page++ ){
                                                    if( $page == $selectedpage ){
                                                        echo '<a href="'.$search_page_location.'?page='.$page.$extra_param.'" class="btn btn-primary">'.$page.'</a> ';
                                                    }else if( $page > 0 && $page <= $pages ){
                                                        echo '<a href="'.$search_page_location.'?page='.$page.$extra_param.'" class="btn btn-secondary">'.$page.'</a> ';
                                                    }
                                                }
                                                if( $selectedpage != $pages && $pages > 1 && isset($_GET['page']) ){
                                                    echo '<a href="'.$search_page_location.'?page='.($selectedpage+1).$extra_param.'" class="btn btn-secondary">Next <i class="fas fa-chevron-right"></i></a> ';
                                                }
                                                if( $pages > 1 && $selectedpage < $pages-2 ){
                                                    echo '<a href="'.$search_page_location.'?page='.$pages.$extra_param.'" class="btn btn-secondary waves-effect waves-dark">Last</a> ';
                                                }
                                            }
                                            ?>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <?php require "../../include/structure/footer.php"; ?>
        </div>
    </div>
</body>
</html>
