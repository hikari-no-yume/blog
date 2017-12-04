<!doctype html>
<html>
<head>
    <meta charset=utf-8>
    <title><?=htmlspecialchars($postTitle)?></title>
    <link rel=stylesheet href="style.css">
</head>
<body>
    <main id="main">
         <a href=/>← Home</a><br>

         <?=$postContent?>
    </main>    
    <?php
    require "disqus.php";
    ?>
</body>
</html>