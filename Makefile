generate: posts/blog-description.md posts/*.post.md media/* assets/*
	php generate.php
	cp assets/* out
	cp -RHf media out/media

clean:
	rm -rf out/*
