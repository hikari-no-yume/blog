<?php

namespace ajf\blog;

require_once '../vendor/autoload.php';

use ColinODell\CommonMark\CommonMarkConverter;

$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
$path = ltrim($path, '/');

header('Content-Type: text/html;charset=utf-8');

if ($path === '' || $path === '/') {
    $files = glob('../posts/*.post.md');
    $files = array_map(function ($file) {
        return basename($file, ".post.md");
    }, $files);
    rsort($files);

    require_once "../templates/home.php";
    return;
} else {
    $postName = basename($path);
    if (!file_exists("../posts/$postName.post.md")) {
        header('HTTP/1.1 404 Not Found');
?>
<!doctype html>
<meta charset=utf-8>
<title>404 Not Found</title>
<h1>404 Not Found</h1>
<?php
        return;
    }

    $postContent = file_get_contents("../posts/$postName.post.md");
    $converter = new CommonMarkConverter();
    $postContent = $converter->convertToHtml($postContent);

    require_once "../templates/post.php";
    return;
}
