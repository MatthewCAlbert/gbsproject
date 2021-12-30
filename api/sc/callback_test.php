<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
</head>
<body>
    
</body>
<script>
    function test(callback){
    $.ajax({
        url: 'http://192.168.100.14:8080/gbs-api/sc/status.php',//'../../gbs-api/sc/tracker.php',
        method: 'POST',
        crossDomain: true,
        dataType: 'text',
        data: {
            id: 'T-1539252465'
        },
        success: function(response){
            alert(response);
            let res = JSON.parse(response);
            callback = res['message'];
            alert(callback);
        }
    });
    return callback;
    }
</script>
</html>