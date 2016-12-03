<!doctype html>
<html>
    <head>
        <meta charset=utf-8>
        <title><?=htmlspecialchars($postTitle)?></title>
        <link rel=stylesheet href=style.css>
    </head>
    <body>
        <main>
            <a href=/>← Home</a><br>

            <?=$postContent?>
        </main>
        <script src="script.js"></script>

        <script type="application/javascript">
            (function() {
                if (config.disqus) {
                    _parent = document.getElementById("main");
                    _disqus_div = document.createElement("div");
                    _disqus_div.id = "disqus_thread";
                    _parent.appendChild(_disqus_div);

                    var d = document, s = d.createElement('script');
                        
                    s.src = disqus.forum_name;
                    
                    s.setAttribute('data-timestamp', +new Date());
                    (d.head || d.body).appendChild(s);
                }                    
            })();
        </script>
    </body>
</html>