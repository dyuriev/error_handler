<!DOCTYPE html>
<html>
<head>
    <title>500 Internal Server Error</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,600&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href='/vendor/dyuriev/error_handler/assets/css/style.css' rel='stylesheet' type='text/css'>


    <script src="/vendor/dyuriev/error_handler/assets/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('div.err_container').css({top:'50%',left:'50%',margin:'-'+($('div.err_container').height() / 2)+'px 0 0 -'+($('div.err_container').width() / 2)+'px'});
        });
    </script>
</head>
<body>
<div class="err_container">
    <?include_once($err_container_file)?>
</div>
</body></html>