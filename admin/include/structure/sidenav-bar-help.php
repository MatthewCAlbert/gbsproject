<div class="logo">
                <a href="<?php echo $main_directory; ?>" class="simple-text logo-normal">
                <img src="<?php echo $main_directory; ?>/assets/img/favicon.png" alt="favicon" width="30px"> GBS eMoney
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <?php 
                        if(isset($_SESSION['useradmin_id'])){
                            echo '
                            <li class="nav-item ">
                            <a class="nav-link" href="'.$main_directory.'/dashboard">
                                <i class="material-icons">dashboard</i>
                                <p class="tag">Dashboard</p>
                            </a>
                            </li>';
                        }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $main_directory; ?>/information">
                            <i class="fas fa-home"></i>
                            <p class="tag">Main Menu</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $main_directory; ?>/information/level">
                            <i class="fas fa-star"></i>
                            <p class="tag">Access Level</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $main_directory; ?>/information/faq">
                            <i class="far fa-question-circle"></i>
                            <p class="tag">FAQ</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $main_directory; ?>/information/privacy">
                            <i class="fas fa-book"></i>
                            <p class="tag">Privacy and Policy</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $main_directory; ?>/information/disclaimer">
                            <i class="fas fa-bookmark"></i>
                            <p class="tag">Disclaimer</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $main_directory; ?>/information/about-us">
                            <i class="fas fa-question-circle"></i>
                            <p class="tag">About</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $main_directory; ?>/information/licenses">
                            <i class="fas fa-receipt"></i>
                            <p class="tag">Licenses</p>
                        </a>
                    </li>
                </ul>
            </div>