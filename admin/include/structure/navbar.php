
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute fixed-top">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <a class="navbar-brand cursor-n">Admin Dashboard</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link">
                                    <?php echo $user_row['name']; ?>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">person</i>
                                    <p>
                                        <span class="d-lg-none d-md-block">Account</span>
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="<?php echo $main_directory; ?>/account"><?php echo $user_row['name']; ?></a>
                                    <a class="dropdown-item" href="<?php echo $main_directory; ?>/account"><i class="fas fa-cog" style="margin-right:5px;"></i>Account Settings</a>
                                    <a class="dropdown-item" href="<?php echo $main_directory; ?>/include/logout.php"><i class="fas fa-sign-out-alt" style="margin-right:5px;"></i>Log Out</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link sm-icon" href="<?php echo $main_directory; ?>/information/level">
                                        <?php echo $user_row['level']; ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->