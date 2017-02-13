generate: $(wildcard posts/blog-description.md) posts/*.post.md $(wildcard media/*) assets/*
	php generate.php
	cp assets/* out
	cp -RHf media out/media

clean:
	rm -rf out/*
