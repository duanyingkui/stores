<!DOCTYPE html>
<html  lang="utf-8">
<head>
    {{--微信端--}}
    <meta charset="utf-8">
    <link rel="icon" href="favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="user-scalable=no,width=device-width, initial-scale=1,maximum-scale=1" name="viewport">
    <meta name="format-detection" content="telephone=no"/>
    <meta content="Title" name="apple-mobile-web-app-title">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">
    <meta name="csrf" content="{{csrf_token()}}">
    <title>这里是标题</title>
</head>
<body>
<div id="app">
</div>
<script src="{{ mix('js/manifest.js') }}"></script>
<script src="{{ mix('js/vendor.js') }}"></script>
<script src="{{ mix('js/wx.js') }}"></script>
</body>
</html>
