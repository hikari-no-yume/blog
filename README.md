# Blog

A minimal blog static site generator written in PHP.

## Setup

`composer install` will install the dependencies.

### Disqus setup

In `assets/scripts.js` set `config.disqus` to `true` and update `disqus.disqus_url` to your disqus URL.

## Directory layout

Create a `posts/` directory and fill it with `.post.md` files. I suggest naming them with the `YYYY-MM-DD-post-name` format, so they sort correctly. The first line will be used as the title.

If you want a description for the front page, create `posts/blog-description.md`.

Media files can be placed in a `media/` directory and referenced likewise in the Markdown (e.g. `![](/media/image.png)`).

## Generating a site

`make` will populate `out/` with the generated site.

`make clean` will clear it.

## Hosting a site

For clean URLs, this software assumes that 1) the site is hosted on the web root and 2) `.html` extensions on posts will be hidden. See `config/nginx/blog.ajf.me` for an example of how to do that..
