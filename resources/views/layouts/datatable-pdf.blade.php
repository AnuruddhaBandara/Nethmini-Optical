<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .page {
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 80%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card-header h1 {
            margin: 0;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .dt-name {
            font-weight: bold;
        }
        .fw-normal {
            font-weight: normal;
        }
        .badge {
            border-radius: 10px;
            padding: 5px 10px;
            font-size: 12px;
            text-transform: uppercase;
        }
        .bg-label-success {
            background-color: #eafbdf !important;
            color: #72e128 !important;
        }

        .bg-label-info {
            background-color: #def6fe !important;
            color: #26c6f9 !important;
        }

        .bg-label-warning {
            background-color: #fff4df !important;
            color: #fdb528 !important;
        }

        .bg-label-danger {
            background-color: #ffe4e4 !important;
            color: #ff4d49 !important;
        }
        .dt-name.small {
            font-size: 12px;
        }
    </style>
</head>
<body>
<div class="container">
    @yield('content')
</div>
</body>
</html>
