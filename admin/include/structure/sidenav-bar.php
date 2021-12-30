<div class="logo">
                <a href="<?php echo $main_directory; ?>" class="simple-text logo-normal" style="font-family:'Quicksand';text-transform: lowercase;font-weight:700;">
                <img src="<?php echo $main_directory; ?>/assets/img/head-logo.png" alt="favicon" width="30px"> gbsproject.
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $main_directory; ?>/dashboard">
                            <i class="material-icons">dashboard</i>
                            <p class="tag">Dashboard</p>
                        </a>
                    </li>
                    <?php 
                        if($user_row['level'] >= 4){
                            echo '
                            <li class="nav-item ">
                            <a class="nav-link" href="'.$main_directory.'/analytics">
                                <i class="fas fa-chart-line"></i>
                                <p class="tag">Analytics</p>
                            </a>
                            </li>';
                        }
                    ?>
                    <?php 
                        if($user_row['level'] >= 3){
                            echo '
                            <li class="nav-item ">
                            <a class="nav-link" href="'.$main_directory.'/transaction">
                                <i class="fas fa-money-check-alt"></i>
                                <p class="tag">Transaction</p>
                            </a>
                            </li>';
                        }
                    ?>
                    <li class="nav-item ">
                        <a class="nav-link" href="<?php echo $main_directory; ?>/search">
                            <i class="far fa-eye"></i>
                            <p class="tag">View</p>
                        </a>
                    </li>
                    <?php 
                        if($user_row['level'] >= 2 ){
                            echo '
                            <li class="nav-item ">
                                <a class="nav-link" href="'.$main_directory.'/register">
                                    <i class="fas fa-pencil-alt"></i>
                                    <p class="tag">Register</p>
                                </a>
                            </li>';
                        }
                    ?>
                    <?php 
                        if($user_row['level'] >= 4){
                            echo '
                            <li class="nav-item ">
                            <a class="nav-link" href="'.$main_directory.'/manager">
                                <i class="fas fa-briefcase"></i>
                                <p class="tag">Manager</p>
                            </a>
                            </li>';
                        }
                    ?>
                    <?php 
                        if($user_row['level'] >= 4){
                            echo '
                            <li class="nav-item ">
                            <a class="nav-link" href="'.$main_directory.'/midtrans">
                                <i class="fas fa-handshake"></i>
                                <p class="tag">Midtrans</p>
                            </a>
                            </li>';
                        }
                    ?>
                    <?php 
                        if($user_row['level'] != 3){
                            echo '
                                <li class="nav-item ">
                                <a class="nav-link" href="'.$main_directory.'/help-desk">
                                    <i class="fas fa-question"></i>
                                    <p class="tag">Help Desk</p>
                                </a>
                            </li>';
                        }
                    ?>
                    <?php 
                        if($user_row['level'] >= 5){
                            echo '
                            <li class="nav-item ">
                            <a class="nav-link" href="'.$main_directory.'/maintenance">
                                <i class="fas fa-toolbox"></i>
                                <p class="tag">Maintenance</p>
                            </a>
                            </li>';
                        }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $main_directory; ?>/account">
                            <i class="fas fa-cog"></i>
                            <p class="tag">Account Settings</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $main_directory; ?>/include/logout.php">
                            <i class="fas fa-sign-out-alt"></i>
                            <p class="tag">Log Out</p>
                        </a>
                    </li>
                </ul>
            </div>