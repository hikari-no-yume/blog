<!doctype html>
<meta charset=utf-8>
<title>Post list</title>
<link rel=stylesheet href=style.css>

<main>
    <h1>Blog</h1>
    <?=$blogDescription ?? ""?>
    <h2>Post list</h2>
    <ul>
        <?php foreach ($posts as $post): ?>
            <li>
                <?php if (isset($post['date'])): ?>
                    <time datetime="<?=$post['date']?>">
                        <?=$post['season']?>
                        <?=$post['year']?>
                    </time>
                    -
                <?php endif; ?>
                <a href="/<?=htmlspecialchars($post["url"])?>"><?=htmlspecialchars($post["title"])?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</main>
