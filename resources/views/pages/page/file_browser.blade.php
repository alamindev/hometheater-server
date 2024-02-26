<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>File Browser</title>

    <style type="text/css">

        body{

            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

            font-size: 80%;



        }

        #form{

            width: 600px;

        }

        #folderExplorer{

            float: left;

            width: 100px;

        }

        #fileExplorer{

            float: left;

            width: 680px;

            border-left: 1px solid #dff0ff;

        }

        .thumbnail{

            float: left;

            margin: 3px;

            padding: 3px;

            border: 1px solid #dff0ff;

        }

        ul{

            list-style: none;

            margin: 0;

            padding: 0;

        }

        li{

             padding: 0;

        }

    </style>

    <script

    src="https://code.jquery.com/jquery-2.2.4.min.js"

    integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="

    crossorigin="anonymous"></script>

<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

<script>

    $(document).ready(function(){

        var funcNum = <?php echo $_GET['CKEditorFuncNum']. ';';?>

        $('#fileExplorer').on('click', 'img', function(){

            var fileUrl = $(this).attr('title');

            window.opener.CKEDITOR.tools.callFunction(funcNum, fileUrl);

            window.close();

        }).hover(function(){

            $(this).css('cursor','pointer');

        });

    })

</script>

</head>

<body>

    <div id="fileExplorer">

        @foreach($fileNames as $fileName)

             <div class="thumbnail">

             <img src="{{ asset('uploads/'. $fileName)}}" alt="humb" title="/uploads/{{$fileName}}" width="200" height="100"/>

             <br/>

             {{ $fileName  }}

             </div>

        @endforeach

    </div>

</body>

</html>

