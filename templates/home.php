<!doctype html>
<meta charset=utf-8>
<title>Post list</title>
<link rel=stylesheet href=style.css>

<main>
    <h1>Blog</h1>
    <?php if (file_exists("../blog_description.php")) { require_once "../blog_description.php"; } ?>
    <h2>Post list</h2>
    <ul>
        <?php foreach($files as $file): ?>
            <li><a href="/<?=htmlspecialchars($file["url"])?>"><?=htmlspecialchars($file["title"])?></a></li>
        <?php endforeach; ?>
    </ul>
</main>
