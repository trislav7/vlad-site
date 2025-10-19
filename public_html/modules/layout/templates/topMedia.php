<!DOCTYPE html>
<html>
  <head>
    <base href="http://<?= $_SERVER['HTTP_HOST'] ?>/" />
    <meta http-equiv="content-language" content="ru">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="<?= $description ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/lib/slick/slick/slick.min.js"></script>
    <link rel="stylesheet" href="/lib/slick/slick/slick.css">
    <link rel="stylesheet" href="/lib/slick/slick/slick-theme.css">

<title><?= $title ?></title>

<?php if (!empty($css)) { ?>
<?php foreach ($css as $cssFile) { ?>    
        <link href="<?= $cssFile ?>" rel="stylesheet">
<?php } ?>
<?php } ?>
<?php if (!empty($js)) { ?>
<?php foreach ($js as $jsFile) { ?>    
        <script src="<?= $jsFile ?>"></script>
<?php } ?>
<?php } ?>
</head>
<body>
Шапка меди
<hr />