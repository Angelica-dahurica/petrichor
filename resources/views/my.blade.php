<!doctype html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}">
<head>
    <meta charset="UTF-8">
    <title>我的</title>
</head>
<body>
<div id="app">
    <my></my>
</div>

<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>