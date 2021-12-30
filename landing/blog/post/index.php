<?php
    require '../../include/server.php';
?>
<?php
    if(isset($_GET['id'])){
        $id = mysqli_escape_string($conn,$_GET['id']);
        $sql="SELECT * FROM `blog` WHERE `id`='$id'";
        $res = $conn->query($sql);
        if($res){
            if($res->num_rows > 0){
                $row = mysqli_fetch_assoc($res);
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        require '../../include/head.php';
    ?>
    <title>Blog | GBS Project - School Cashless Solution</title>
</head>
<body>
    <div id="main-container">
        <?php 
            require '../../include/header.php';
        ?>
        <div id="main-wrapper">
            <?php
                if(isset($_GET['id'])){
                    if($res){
                        if($res->num_rows > 0){
                            echo '
                            <div class="container-fluid page-header">
                                <div class="row">
                                    <div class="col-12">
                                        <h2>'.$row['title'].'</h2><br>
                                        <h6>'.$row['tags'].$row['update_time'].'</h6>
                                    </div>
                                </div>
                            </div>';
                        }
                    }
                }
            ?>
            <div class="container-fluid">
                <div class="section" id="section-1">
                    <div class="row">
                        <?php 
                            if(isset($_GET['id'])){
                                if($res){
                                    if($res->num_rows > 0){
                                        echo '
                                        <div class="col-12">
                                            <img class="lazy" data-src="'.$row['image'].'" alt="post-image" width="100%">
                                            <p>'.$row['content'].'</p><br>
                                            <h6>'.$row['author'].'</h6>
                                        </div>';
                                    }else{
                                        echo '<div class="col-12">Post Not Found/Exist.</div>';
                                    }
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            require '../../include/footer.php';
        ?>
    </div>
</body>
</html>