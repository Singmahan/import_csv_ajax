<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">

    <title>Document</title>
</head>
<body>

    <div class="container mt-5">
        <h1 align="center">Import CSV File Data with Progress Bar in PHP using Ajax</h1>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading mt-5">
                    <h3 class="panel-title" align="center">Import CSV File Data</h3>
                </div>
                <div class="panel-body">
                    <span id="message"></span>
                    <form id="sample_form" method="POST" class="form-inline" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Select CSV File</label>
                            <input type="file" name="file" id="file">
                        </div>
                        <div class="form-group" >
                            <input type="hidden" name="hidden_field" value="1">
                            <input type="submit" name="import" id="import" class="btn btn-success" value="Import">
                        </div>
                    </form>
                    <div class="form-group" id="process" style="display: none;">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                <span id="process_data">0</span> - <span id="total_data">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function(){
            var clear_timer;
            $('#sample_form').on('submit', function(event){
                $('#message').html('');
                event.preventDefault();
                $.ajax({
                    url: "upload.php",
                    method: "POST",
                    data: new FormData(this),
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(data){
                        if(data.success){
                            $('#total_data').text(data.total_line);
                            start_import();

                            clear_timer = setInterval(get_import_data, 2000);

                            $('#message').html('<div class="alert alert-success">CSV File Uploaded</div>');
                        }if(data.error){
                            $('#message').html('<div class="alert alert-danger">'+data.error+'</div>');
                        }
                    }
                })
            });
            function start_import(){
                $('#process').css('display', 'block');
                $.ajax({
                    url:"import.php",
                    success:function(){

                    }
                })
            }
            function get_import_data(){
                $.ajax({
                    url: "process.php",
                    success:function(data){
                        var total_data = $('#total_data').text();
                        var width = Math.round((data/total_data) * 100);
                        $('#process_data').text(data);
                        $('.progress-bar').css('width', width + '%');

                        if(width >= 100){
                            clearInterval(clear_timer);
                            $('#process').css('display', 'none');
                            $('#file').val('');
                            $('#message').html('<div class="alert alert-success">Data Successfully Imported</div>');
                        }
                    }
                })
            }

        });
    </script>
</body>
</html>