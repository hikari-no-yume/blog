<?php

if ($config['disqus']['enabled']) {
    ?>
    <script type="application/javascript">
        (function() {
            _parent = document.getElementById("main");
            _disqus_div = document.createElement("div");
            _disqus_div.id = "disqus_thread";
            _parent.appendChild(_disqus_div);

            var d = document, s = d.createElement('script');
                
            s.src = "<?=$config['disqus']['url']?>";
            
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <?php
}
