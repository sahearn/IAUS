<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>IAUS (It's Another URL Shortener)</title>
    <meta name="description" content="Custom URL Shortener">
    <meta name="author" content="Scott A'Hearn">

    <meta property="og:title" content="IAUS (It's Another URL Shortener)">
    <meta property="og:type" content="website">
    <meta property="og:url" content="http://[your site]/">
    <meta property="og:description" content="A simple URL shortener">
    <meta property="og:image" content="">

    <link rel="icon" href="/favicon.ico">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/vendor/modernizr-3.11.2.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
    <script src="js/custom.js"></script>
    
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/custom.css?v=2.1">
</head>
<body>

<div id="header">
    It's Another URL Shortener!
</div>

<div class="flexcontainer">
    <form id="shortform">
        <input id="id_entrybar" name="fm_entrybar" type="text" placeholder="Enter link here" maxlength="2000">
        <input id="id_submit" name="fm_submit" type="submit" value="Shorten URL">
    </form>
</div>

<div class="flexcontainer">
    <div id="resultcontainer">
        <div id="resultcontent">
            <div id="longurlpart"></div>
            <div id="shorturl" shortlink=""></div>
            <div id="copylink"><span onclick="copyShort()">Copy</a></div>
        </div>
    </div>
</div>

</body>
</html>
