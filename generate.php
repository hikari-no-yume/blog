<?php

namespace ajf\blog;

require_once __DIR__ . '/vendor/autoload.php';

use League\CommonMark\CommonMarkConverter;

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

$posts = [];
$files = glob('posts/*.post.md');
rsort($files);
$posts = array_map(function ($file) {
    $fields = [];
    $fields['url'] = basename($file, ".post.md");
    $fields['title'] = postTitle($file, TRUE);
    $fields['content'] = file_get_contents($file);
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

if (file_exists('posts/blog-description.md')) {
    $blogDescription = file_get_contents("posts/blog-description.md");
    $converter = new CommonMarkConverter();
    $blogDescription = $converter->convertToHtml($blogDescription);
} else {
    $blogDescription = NULL;
}

ob_start();
require_once "templates/home.php";
file_put_contents("out/index.html", ob_get_clean());

foreach ($posts as $post) {
    $postTitle = $post["title"];
    $converter = new CommonMarkConverter();
    $postContent = $converter->convertToHtml($post["content"]);

    ob_start();
    require "templates/post.php";
    file_put_contents("out/$post[url].html", ob_get_clean());
}
