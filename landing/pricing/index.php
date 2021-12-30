<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        require '../include/head.php';
    ?>
    <title>GBS Project - School Cashless Solution</title>
    <style>
        .p-wrapper{
            text-align:center;
            min-height:100px;
            padding:20px;
        }
        .p-container{
            background-color: rgba(0,0,0,0.2);
            border-radius: 5px;
            min-height:100px;
            cursor:default;
            transition: .3s;
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
        }
        .p-container:not(.disabled):hover{
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }
        .p-header{
            background-color:rgba(255,255,255,0.5);
            color:black;
            padding:10px 0;
        }
        .p-container .na{
            color: rgba(0,0,0,0.6);
            font-size: 1.3em;
        }
        .p-content{
            padding:5% 5%;
        }
        
        .p-container.disabled{
            cursor: not-allowed;
        }
    </style>
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
                        <h2>Pricing</h2><br>
                        <h6>Select package based on your needs.</h6>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="section" id="section-1">
                    <div class="row">
                        <div class="col-lg-4 col-12 p-wrapper">
                            <div class="p-container disabled">
                                <div class="p-header"><h5>Small Canteen*</h5></div>
                                <div class="p-content">
                                    <p class="na">Not Available</p>
                                    <ul class="text-left" style="margin:auto;display:table;">
                                        <li>EDC Units : 2-12 units</li>
                                        <li>Min. Internet Speed : 5Mbps</li>
                                        <li>Users : 0-100 users</li>
                                        <li>RFID Member Card required.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12 p-wrapper">
                            <div class="p-container">
                                <div class="p-header"><h5>School Canteen*</h5></div>
                                <div class="p-content">
                                    <p>Perfect for your better school.</p>
                                    <ul class="text-left" style="margin:auto;display:table;">
                                        <li>EDC Units : 12-32 units</li>
                                        <li>Min. Internet Speed : 10-30Mbps</li>
                                        <li>Users : 100-1200 users</li>
                                        <li>RFID Student/Staff Card required.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12 p-wrapper">
                            <div class="p-container disabled">
                                <div class="p-header"><h5>Enterprise*</h5></div>
                                <div class="p-content">
                                    <p class="na">Not Available</p>
                                    <ul class="text-left" style="margin:auto;display:table;">
                                        <li>EDC Units : >32 units</li>
                                        <li>Min. Internet Speed : 50-100Mbps</li>
                                        <li>Users : >1200 users</li>
                                        <li>RFID Member Card required.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-secondary" style="font-size:.85em;">* Contact for price listing.</p>
                </div>
            </div>
        </div>
        <?php 
            require '../include/footer.php';
        ?>
    </div>
</body>
</html>