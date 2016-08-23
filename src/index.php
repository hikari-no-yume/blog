<?php

namespace ajf\blog;

require_once '../vendor/autoload.php';

use League\CommonMark\CommonMarkConverter;

$path = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
$path = ltrim($path, '/');
// ignore query string
list($path, ) = explode('?', $path, 2);
$path = urldecode($path);

header('Content-Type: text/html;charset=utf-8');

function postTitle($file, $isFilename = FALSE) {
    if ($isFilename) {
        $fp = fopen($file, "r");
        $postTitle = fgets($fp);
        fclose($fp);
    } else {
        if (($pos = strpos($file, "\n")) !== FALSE) {
            $postTitle = substr($file, 0, $pos);
        } else {
            $postTitle = $file;
        }
    }

    // strip markdown title formatting, newlines
    $postTitle = rtrim(ltrim($postTitle, '#='), "=\n\r");

    return $postTitle;
}

if ($path === '' || $path === '/') {
    $files = glob('../posts/*.post.md');
    rsort($files);
    $files = array_map(function ($file) {
        $fields = [];
        $fields['url'] = basename($file, ".post.md");
        $fields['title'] = postTitle($file, TRUE);
        if (preg_match('/^((\d\d\d\d)-(\d\d)-\d\d)-/', $fields['url'], $matches)) {
            $fields['date'] = $matches[1]; // whole YYYY-MM-DD date
            $fields['year'] = $matches[2]; // YYYY
            $month = (int)$matches[3]; // MM
            $fields['season'] = [
                3   => '🌱',     4   => '🌱',     5   => '🌱',
                6   => '☀️',     7   => '☀️',     8   => '☀️',
                9   => '🍁',     10  => '🍁',     11  => '🍁',
                12  => '🎄',     1   => '❄️',     2   => '❄️',
            ][$month];
        }
        return $fields;
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
    $postTitle = postTitle($postContent);
    $converter = new CommonMarkConverter();
    $postContent = $converter->convertToHtml($postContent);

    require_once "../templates/post.php";
    return;
}
