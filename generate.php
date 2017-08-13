<?php declare(strict_types=1);

namespace ajf\blog;

require_once __DIR__ . '/vendor/autoload.php';

use League\CommonMark\CommonMarkConverter;

$posts = [];
$files = glob('posts/*.post.md');
rsort($files);
$posts = array_map(function ($file) {
    $fields = [];
    $fields['url'] = basename($file, ".post.md");
    $fields['content'] = file_get_contents($file);

    if (($pos = strpos($fields['content'], "\n")) !== false) {
        $fields['title'] = substr($fields['content'], 0, $pos);
    } else {
        $fields['title'] = $fields['url'];
    }
    // strip markdown title formatting, newlines
    $fields['title'] = rtrim(ltrim($fields['title'], '#='), "=\n\r");

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
    $blogDescription = null;
}

ob_start();
require_once "templates/home.php";
file_put_contents("out/index.html", ob_get_clean());

foreach ($posts as $post) {
    $postTitle = $post["title"];
    $postUrl        = $post["url"];
    $converter = new CommonMarkConverter();
    $postContent = $converter->convertToHtml($post["content"]);

    ob_start();
    require "templates/post.php";
    file_put_contents("out/$post[url].html", ob_get_clean());
}
