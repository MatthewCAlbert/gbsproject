        <header>
            <nav class="d-flex">
                <a href="<?php echo $main_directory; ?>" class="nav-logo d-flex">
                <img src="<?php echo $main_directory; ?>assets/img/cover-logo.png" alt="logo">
                <span>gbsproject.</span>
                </a>
                <div class="nav-links ml-auto d-flex align-items-center">
                        <a href="<?php echo $main_directory; ?>product" class="small-hide un">PRODUCTS</a>
                    <a href="<?php echo $main_directory; ?>pricing" class="small-hide un">PRICING</a>
                    <a href="<?php echo $main_directory; ?>register" class="small-hide md-icon" style="margin-right:-20px;">REGISTER YOUR SCHOOL</a>
                    <span id="menu-cover">
                    <a href="javascript:void(0)" onclick="toggleNav()" id="menu-button"><i class="material-icons">menu</i></a>
                    </span>
                </div>
            </nav>
            <aside class="sidenav">
                <a href="javascript:void(0)" onclick="toggleNav()" id="close-button"><i class="material-icons">close</i></a>
                <ul>
                    <li><a href="<?php echo $main_directory; ?>register">REGISTER YOUR SCHOOL</a></li>
                    <li class="hr hr-80"></li>
                    <li><a href="<?php echo $main_directory; ?>">HOME</a></li>
                    <li><a href="<?php echo $main_directory; ?>product">PRODUCTS</a></li>
                    <li><a href="<?php echo $main_directory; ?>pricing">PRICING</a></li>
                    <li><a href="<?php echo $main_directory; ?>affiliation">AFFILIATION</a></li>
                    <li class="hr hr-80"></li>
                    <li><a href="https://web.gbsproject.com">WEB APP</a></li>
                    <li><a href="<?php echo $main_directory; ?>faq">FAQ</a></li>
                    <li><a href="<?php echo $main_directory; ?>contact">CONTACT</a></li>
                    <li><a href="<?php echo $main_directory; ?>tnc">TERMS & CONDITIONS</a></li>
                    <li><a href="<?php echo $main_directory; ?>about">ABOUT</a></li>
                </ul>
            </aside>
            <div class="loader-wrapper">

            </div>
            <div id="help-button" onclick="toggleHelp()">
                <i class="far fa-question-circle fa-lg" style="margin-right:2px;"></i> HELP
            </div>
            <div id="help-area">
                <div class="d-flex flex-column">
                    <div class="p-4" style="background:rgba(0,0,0,0.3);border-radius:10px;">
                        Help Bar
                        <span onclick="toggleHelp()" id="help-close"><i class="material-icons">close</i></span>
                    </div>
                    <div class="p-3 link" onclick="href('mailto:emoney.gbs@gmail.com')">
                    <i class="fas fa-envelope"></i> Email Us
                    </div>
                    <div class="p-3 link" onclick="href('<?php echo $main_directory; ?>contact')">
                    <i class="fas fa-address-book"></i> Contact Page
                    </div>
                </div>
            </div>
        </header>