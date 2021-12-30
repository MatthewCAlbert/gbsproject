<?php
    require '../include/server.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        require '../include/head.php';
    ?>
    <title>Blog | GBS Project - School Cashless Solution</title>
</head>
<body>
    <div id="main-container">
        <?php 
            require '../include/header.php';
        ?>
        <div id="main-wrapper">
            <div class="container-fluid page-header">
                <div class="row">
                    <div class="col-12">
                        <h2>Blog</h2><br>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="section" id="section-1">
                    <div class="row">
                        <?php
                            $sql="SELECT * FROM `blog`";
                            $res = $conn->query($sql);
                            if($res){
                                if($res->num_rows > 0){
                                    while($row = mysqli_fetch_array($res)){
                                        $string = strip_tags($row['content']);
                                        if (strlen($string) > 100) {
                                            // truncate string
                                            $stringCut = substr($string, 0, 100);
                                            $endPoint = strrpos($stringCut, ' ');
                                            //if the string doesn't contain any space then it will cut without word basis.
                                            $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
                                            $string .= '...';
                                        }
                                        echo '
                                        <div class="col-12">
                                            <img class="lazy" data-src="'.$row['image'].'" alt="post-image" width="140px">
                                            <h3>'.$row['title'].'</h3>
                                            <p>'.$row['update_time'].'</p>
                                            <p>'.$string.'</p>
                                            <a href="post?id='.$row['id'].'" class="btn btn-primary">Read More..</a>
                                            <p>'.$row['tags'].'</p>
                                        </div>';
                                    }
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            require '../include/footer.php';
        ?>
    </div>
</body>
</html>