<footer class="footer ">
                <div class="container-fluid">
                    <nav class="pull-left">
                        <ul>
                            <li>
                                <a href="<?php echo $main_directory; ?>/../gbsproject">
                                    Main Site
                                </a>
                            </li>
                            <?php
                            if(!isset($_SESSION['useradmin_id'])){
                                echo '
                                <li>
                                    <a href="'.$main_directory.'/login">
                                        Login
                                    </a>
                                </li>';
                            }
                            ?>
                            <li>
                                <a href="<?php echo $main_directory; ?>/information">
                                    Help
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $main_directory; ?>/information/about-us">
                                    About Us
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $main_directory; ?>/information/licenses">
                                    Licenses
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="copyright pull-right">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script> 
                        <a href="#">GBS eMoney Project</a> for school canteen.
                    </div>
                </div>
</footer>
<script>
    $(document).ready(function(){
        //overide change primary color
        //('.card-header-primary .card-icon').css({'background':'navy'});
        //$('.btn-primary').css({'background-color':'navy'}); //on hover shadow not added yet
        //$('.sidebar-wrapper .nav-item.active .nav-link').css({'background-color':'navy'});
    });
</script>