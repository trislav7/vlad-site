<?php
if (!defined('_PS_MAGIC_QUOTES_GPC_')) {
    define('_PS_MAGIC_QUOTES_GPC_', false);
}

/**
 * Ого, вы нашли файл главной страницы сайта! И промокод INDEX, который даст
 * скидку 10% на товары в Спринтшопе: shop.sprinthost.ru
 * У нас там прикольный мерч!
 */

/**
 * Эта строчка кода отображает стандартную заглушку. Замените ее,
 * если у вас уже есть сайт
 *
 * Если что — пишите в поддержку, поможем
 */

//include("/opt/index.php") 

spl_autoload_register(function ($class) {
    $folder = str_replace('Controller', '', $class);
    $folder = strtolower(str_replace('Managers', '', $folder));

//    d($folder);

    if ($folder != 'routs' && $folder != 'db' && $folder != 'news' && $class != 'LayoutManagersController' && $class != 'Controller' && $class != 'UrlsManagersController' && $class != 'CategoriesManagersController') {
//        dump('./modules/' . $folder. '/' . $class . '.php');
//         d($folder);
    }
    if (file_exists('./modules/' . $folder. '/' . $class . '.php')) {
        include './modules/' . $folder. '/' . $class . '.php';
    } elseif (file_exists('./engine/' . $class . '.php')) {
        include './engine/' . $class . '.php';
    } elseif (preg_match('{\/managers\/}', $_SERVER['REQUEST_URI'])) {
        include './modules/' . $folder. '/managers/' . $class . '.php';
    } elseif ($class == 'LayoutManagersController') {
        include './modules/layout/managers/' . $class . '.php';
    }
});

$urlsStr = [];
$fileCacheUrl = './cache/urls.cache';
if (file_exists($fileCacheUrl)) {
    $urlsArray = file_get_contents($fileCacheUrl);
    if (!empty($urlsArray)) {
        $urlsStr = json_decode($urlsArray, true);
    }
}

//echo('<pre>'); var_dump($urlsStr); die();

$url = isset($urlsStr[1][$_SERVER['REQUEST_URI']]) ? $urlsStr[1][$_SERVER['REQUEST_URI']] : $_SERVER['REQUEST_URI'];

include('./engine/Init.php');
include('./engine/config.conf');
new Init($url);