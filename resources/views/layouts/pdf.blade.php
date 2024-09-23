<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Layout</title>
    <style type="text/css">
        *{
            font-family: sans-serif;
        }
        body{
            width: calc(210mm - 100px);
            height: calc(297mm - 10px);
            margin: 0 auto;
            padding: 0;
        }
        h1, h2, h3{
            margin: 0;
        }
        h1{
            font-size: 20px;
        }
        h2, h3{
            font-size: 14px;
        }
        h2.h1{
            font-size: 17px;
        }
        .page{
            border: 1px solid #cccccc;
            border-radius: 10px;
            overflow: hidden;
        }
        .label{
            border-radius: 50rem;
            padding: 0.35em 0.583em;
            font-size: 12px;
            font-weight: 600;
        }
        .label-success{
            color: #72e128;
            background-color: #eafbdf;
        }
        .label-active{
            color: #ff4d49;
            background-color: #ffe4e4;
        }
        .text-end{
            text-align: right;
        }
        .card-header, .card-body{
            padding: 40px;
        }
        .card-header{
            background-color: #f9f8f9;
        }
        .card-body h3{
            font-size: 14px;
        }
        .card-body h3 span{
            position: relative;
            top: -3px;
            margin-left: 3px;
        }
        .card-body label{
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
        }
        .card-body table{
            margin-bottom: 40px;
        }
        .map{
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .card-body table.map-info{
            margin-bottom: 0;
        }
        .card-body table.map-info label{
            margin-bottom: 10px;
        }
        .start-end{
            display: inline-block;
            height: 0.75rem;
            width: 0.75rem;
            border-radius: 50%;
            box-shadow: 0 0 0 10px #ffffff;
            margin-right: 5px;
        }
        .start{
            background-color: #72e128;
            outline: 3px solid rgba(114, 225, 40, 0.12);
        }
        .end{
            background-color: #ff4d49;
            outline: 3px solid rgba(255, 77, 73, 0.12);
        }
        .guardian-details{
            max-width: 290px;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
<div class="container">
    @yield('content')
</div>
</body>
</html>
