<?php

namespace ajf\blog;

require_once '../vendor/autoload.php';

use ColinODell\CommonMark\CommonMarkConverter;

$path = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
$path = ltrim($path, '/');
$path = urldecode($path);

header('Content-Type: text/html;charset=utf-8');

if ($path === '' || $path === '/') {
    $files = glob('../posts/*.post.md');
    rsort($files);
    $files = array_map(function ($file) {
        $postName = basename($file, ".post.md");
        $fp = fopen($file, "r");
        $firstLine = fgets($fp);
        fclose($fp);
        $firstLine = rtrim(ltrim($firstLine, '#='),'='); // strip Markdown title
        return [
            "title" => $firstLine,
            "url" => $postName
        ];
    }, $files);

    if (file_exists('../posts/blog-description.md')) {
        $blogDescription = file_get_contents("../posts/blog-description.md");
        $converter = new CommonMarkConverter();
        $blogDescription = $converter->convertToHtml($blogDescription);
    } else {
        $blogDescription = NULL;
    }

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
