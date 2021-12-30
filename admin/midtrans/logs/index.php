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
    ?>
    <title>Transaction Bot Logs - GBS eMoney Admin</title>
    <?php require "../../include/structure/script.php"; ?>
    <script>
        $(document).ready(function(){
            $(".nav .nav-item:contains('Midtrans')").addClass('active');
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
                            <div class="card-header card-chart card-header-success">
                                <h4 class="card-title">Transaction Bot Logs</h4>
                                <p class="card-category">Search</p>
                            </div>
                            <div class="card-body">
                            <form class="card-category">
                                <div class="row">
                                    <div class="col-3">
                                        <label for="">Specific Date</label>
                                        <input type="date" name="q" class="form-control" value="">
                                    </div>
                                    <div class="col">
                                        <label for="">From</label>
                                        <input type="date" class="form-control" name="date-from" value="2018-09-01">
                                    </div>
                                    <div class="col">
                                        <label for="">To</label>
                                        <input type="date" class="form-control" name="date-to" value="<?php echo date("Y-m-d"); ?>">
                                    </div>
                                    <div class="col">
                                        <label for="">Sort</label>
                                        <select name="sort" class="form-control">
                                            <option value="1">ASC</option>
                                            <option value="2" selected>DESC</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                    <button class="btn btn-primary" type="button" onclick="search();"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                            </div>
                            <div class="card-footer">
                                <div class="table-responsive" id="result">
                                <!-- Content -->
                                </div>
                            </div>
                            
                            <div class="page-number text-center">
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <?php require "../../include/structure/footer.php"; ?>
        </div>
    </div>
</body>
<script>
    $(document).ready(()=>{
        search();
    });
    function search(){
        $("#result").html("");
        var search = $("input[name=q]").val();
        var sort = $("select[name=sort]").val();
        var date_from = $("input[name=date-from]").val();
        var date_to = $("input[name=date-to]").val();
        var start = new Date(date_from),
            end = new Date(date_to),
            year = start.getFullYear(),
            month = start.getMonth()
            day = start.getDate(),
            dates = [start];
        var date_compiled = [];

        while(dates[dates.length-1] < end) {
            let c_date = new Date(year, month, ++day);
            let s_year = getZero(c_date.getFullYear().toString(),2);
            let s_month = getZero((c_date.getMonth()+1).toString(),2);
            let s_date = getZero((c_date.getDate()-1).toString(),2);
            final_date = s_year+s_month+s_date;
            //console.log(final_date);
            dates.push(c_date);
            date_compiled.push(final_date);
        }

        if( search != "" ){
        search = search.split('-');
        search = search[0]+search[1]+search[2];
        }

        $.ajax({
            url: 'http://192.168.100.14:8080/gbs-api/sc/logs_sourcer.php',//'http://api.gbsproject.ga/sc/logs_sourcer.php',
            method: 'POST',
            crossDomain: true,
            dataType: 'text',
            data: {
                key: 'kT2K78fKXsSA6BPh',
                param: "search",
            },
            success: function(response){
                let res = JSON.parse(response);
                let data = res['message'];
                appendData(data,search,sort,date_compiled);
            }
        });
    }
    function appendData(data,search,sort,date_range){
        $("#result").append("<ul>");
            if( search == "" ){
                var append = [];
                let final_append = "";
                for(let param in data){
                    if( date_range.includes(param) ){
                        for(let detail in data[param]){
                            append.push("<li><a href=\"view.php?file="+data[param][detail]+"\">"+data[param][detail]+"</a></li>");
                        }
                    }
                }
                console.log(sort);
                if( sort == "1" ){
                    for( let i = 0 ; i < append.length ; i++ ){
                        final_append+=append[i];
                    }
                }else{
                    for( let i = append.length-1 ; i >= 0 ; i-- ){
                        final_append+=append[i];
                    }
                }
                $("#result").append(final_append);
            }else{
                for( let detail in data[search] ){
                    $("#result").append("<li><a href=\"view.php?file="+data[search][detail]+"\">"+data[search][detail]+"</a></li>");
                }
            }
        $("#result").append("</ul>");
    }
    function getZero(x,need){
        if( x.length < need ){
            let final = "";
            for( let i = 0 ; i < (need-x.length) ; i++ ){
                final+= "0";
            }
            return final+x;
        }else{
            return x;
        }
    }

    $(document).keypress(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '13') {
            search();
        }
    });
</script>
</html>
