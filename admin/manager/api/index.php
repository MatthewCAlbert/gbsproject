<?php 
    require "../../include/structure.php";
    require '../../include/server.php';
    require '../../include/session.checker.php';
    require '../../include/getuserdata.php';
    if( $user_row['level'] < 4 ){
        header("Location: $main_directory/error/403");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    require '../../include/structure/header.php'; 
    require 'search.php';
    ?>
    <title>Search API - GBS eMoney Admin</title>
    <?php require "../../include/structure/script.php"; ?>
    <script>
        $(document).ready(function(){
            $(".nav .nav-item:contains('Manager')").addClass('active');
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
                            <div class="card-header card-chart card-header-rose">
                                <h4 class="card-title">API Search</h4>
                                <p class="card-category">Manager</p>
                            </div>
                            <div class="card-body">
                            <form class="card-category" method="get" action="<?php echo $search_page_location ?>">
                                <div class="row">
                                    <input type="hidden" name="page" value="1" hidden>
                                    <div class="col-7">
                                    <input type="text" name="q" class="form-control" placeholder="Search..." value="<?php if(isset($_GET['q'])){ echo $search;} ?>">
                                    </div>
                                    <div class="col">
                                        <select name="target" class="form-control" onclick="switchFilterOption()">
                                            <option value="username">Username</option>
                                            <option value="type">Type</option>
                                            <option value="status">Status</option>
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
                                                    <th>API Username</th>
                                                    <th>Type</th>
                                                    <th>Access</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                            while($row = mysqli_fetch_array($res)){
                                                
                                                switch($row['status']){
                                                    case 'banned' : $status = '<span class="text-danger">'.$row['status'].'</span>';break;
                                                    case 'active' : $status = '<span class="text-success">'.$row['status'].'</span>';break;
                                                    default : $status = '<span class="text-warning">'.$row['status'].'</span>';break;
                                                }

                                                $edit_link = "'edit.php?username=".$row['username']."'";
                                                $edit_icon = '';
                                                if( $user_row['level'] >= 4 ){
                                                    $edit_icon = '
                                                    <td class="td-actions text-center">
                                                        <button type="button" rel="tooltip" class="btn btn-warning" onclick="href('.$edit_link.');">
                                                            <i class="material-icons">edit</i>
                                                        </button>
                                                    </td>';
                                                }

                                                echo '
                                                <tr>
                                                    <td>'.$row['username'].'</td>
                                                    <td>'.$row['type'].'</td>
                                                    <td>'.$row['access'].'</td>
                                                    <td class="text-center">'.$status.'</td class="text-center">'.$edit_icon.
                                                '</tr>'; 
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
