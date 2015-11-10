<!doctype html>
<meta charset=utf-8>
<title>Post list</title>
<link rel=stylesheet href=style.css>

<main>
    <h1>Blog</h1>
    <?php if ($blogDescription !== NULL) { echo $blogDescription; } ?>
    <h2>Post list</h2>
    <ul>
        <?php foreach ($files as $file): ?>
            <li>
                <?php if (isset($file['date'])): ?>
                    <time datetime="<?=$file['date']?>">
                        <?=$file['season']?>
                        <?=$file['year']?>
                    </time>
                    -
                <?php endif; ?>
                <a href="/<?=htmlspecialchars($file["url"])?>"><?=htmlspecialchars($file["title"])?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</main>
