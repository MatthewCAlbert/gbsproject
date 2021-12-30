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
    <title>User Search - GBS eMoney Admin</title>
    <?php require "../../include/structure/script.php"; ?>
    <script>
        $(document).ready(function(){
            $(".nav .nav-item:contains('View')").addClass('active');
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
                                <h4 class="card-title">Users</h4>
                                <p class="card-category">Search</p>
                            </div>
                            <div class="card-body">
                            <form class="card-category" method="get" action="<?php echo $search_page_location ?>" autocomplete="off">
                                <div class="row">
                                    <input type="hidden" name="page" value="1" hidden>
                                    <div class="col-6">
                                    <input type="text" name="q" class="form-control" placeholder="Search..." value="<?php if(isset($_GET['q'])){ echo $search;} ?>">
                                    </div>
                                    <div class="col">
                                        <select name="target" id="filter1" class="form-control" onclick="switchFilterOption()">
                                            <option value="all">All</option>
                                            <option value="student">Student</option>
                                            <option value="teacher">Teacher/Staff</option>
                                            <option value="vendor">Vendor</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select name="by" id="filter2" class="form-control" onclick="switchFilterOption()">
                                            <option value="id">ID/NIS</option>
                                            <option value="card_id" selected>Card ID</option>
                                            <option value="name">Name</option>
                                            <option value="status">Status</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select name="sort" id="type-filter" class="form-control" onclick="switchFilterOption()">
                                            <option value="1">ASC</option>
                                            <option value="2">DESC</option>
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
                                    <script>applyFilterOption();</script>
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
                                        $selectedpage = mysqli_escape_string($conn,$_GET['page']);
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
                                    $sql = $sql." LIMIT $start,$ppg"; 
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
                                                    <th class="text-center">ID/NIS</th>
                                                    <th>Name</th>
                                                    <th>Job</th>
                                                    <th>Status</th>
                                                    <th>Email</th>
                                                    <th>Phone No</th>
                                                    <th class="text-right">Balance</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                            while($row = mysqli_fetch_array($res)){
                                                $who = checkWho($row["id"]);
                                                
                                                switch($row['status']){
                                                    case 'banned' : $status = '<span class="text-danger">'.$row['status'].'</span>';break;
                                                    case 'active' : $status = '<span class="text-success">'.$row['status'].'</span>';break;
                                                    default : $status = '<span class="text-warning">'.$row['status'].'</span>';break;
                                                }

                                                $edit_link = "'edit.php?id=".$row['id']."'";
                                                $edit_icon = '';
                                                if( $user_row['level'] >=2 ){
                                                    $edit_icon = '
                                                    <td class="td-actions text-center">
                                                        <button type="button" rel="tooltip" class="btn btn-success" onclick="href('.$edit_link.');">
                                                            <i class="material-icons">edit</i>
                                                        </button>
                                                    </td>';
                                                }

                                                echo '
                                                <tr>
                                                    <td class="text-center">'.$row['id'].'</td>
                                                    <td>'.$row['name'].'</td>
                                                    <td>'.$who.'</td>
                                                    <td>'.$status.'</td>
                                                    <td>'.$row['email'].'</td>
                                                    <td>'.$row['phone'].'</td>
                                                    <td class="text-right">Rp '.number_format($row['balance']).'</td>'.$edit_icon.'
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
                                                if( $selectedpage != $pages && $pages > 1 ){
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
