<?php
    if($user_row['level'] <=4 ){
        header("Location: $main_directory/error/403");
        exit();
    }