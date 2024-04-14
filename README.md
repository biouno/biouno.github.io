# BioUno.org

[![Deploy Hugo site to Pages](https://github.com/biouno/biouno.github.io/actions/workflows/pages.yaml/badge.svg)](https://github.com/biouno/biouno.github.io/actions/workflows/pages.yaml)

BioUno website.

## Building

You must install Hugo to build the project locally. The
Hugo [website][hugo] contains information to install it on
Linux, macOS, and Windows. Hugo is written in Go, so you
will have to install Go as well — refer to Hugo website.

Go into the directory where you cloned this repository, and
run Hugo to build or to serve the website locally.

```console
# This will build
$ hugo

# This will serve and watch for changes
$ hugo server --watch
```

If you want to have a more verbose output, you can use this
variation.

```console
$ hugo server --navigateToChanged --buildDrafts --buildFuture --watch --verbose
```

And if you want to make sure that you are not having problems
with caching, you can remove the `public` directory, which is
used by Hugo to build the blog.

```console
$ rm -rf public && hugo server --navigateToChanged --buildDrafts --buildFuture --watch --verbose
```

### Creating a new page

If you create a new section (e.g. `faq`), you will have to create
a directory with a `_index.md` file. See existing directories like
`./content/blog/` or `./content/tutorials/` for example.

To add a page to an existing section, the simplest option is to just
copy an existing page. You can also create an empty Markdown page
(e.g. `./content/faq/new-file.md`).

If you are building the site with `--watch`, you should be able to
navigate to that page already at <http://localhost:1313/faq/new-file.html>.

Existing pages (and posts) contain a YAML header, called “front matter”.
You can copy an existing header as example.

```markdown
---
title: Give it some nice title
---

This is markdown.

<p>Or HTML...</p>
```

### Creating a new post

Blog posts are created in the directory `/content/blog/`. The
existing posts were migrated from Jekyll, so we need to follow
the existing pattern for consistency.

- `2020-01-20-url-friendly-title.md`

In the example above, `2020-01-20` is the post date. This is not
really used, but it can be added just for the sake of keeping up
with the existing pattern.

The `url-friendly-title` is the part that will be used in the URL,
so choose one that is unique and simple, with dashes or underscores.

Before writing the post content, the front matter YAML header
needs to be added, as in the example below.

```markdown
---
title: "Advanced Cross-Project Linking of Jenkins Artifacts"
description: "Linking Data-Source Builds and their Metadata"
tags: [Jenkins, workflow, data-sciences, analysis, bioinformatics, metadata]
author: Ioannis K. Moutsatsos
date: 2020-02-02
---

Any markdown **content** here. Like in GitHub.

<p>Or some <strong>HTML</strong>.</p>
```

The front matter header above defines a title, that appears in
the web page generated. The description is used in the blog
listing as a summary for the post (when visiting the URL `/blog/`).

The tags are used to classify the post. Fill in the author name
and the date. The date will be used to produce the URL slug
name (`/2020/02/02/advanced...` in the example above).

Preview your post locally — building and serving locally, as
per instructions above — and commit to a pull request or to
a branch like `master` once you are done. In a few seconds the
GitHub Actions pipeline will run, and if it succeeds the site
will be updated with your post.

GitHub Actions builds take seconds to one or minutes.

## Contributing

All contributions are welcome! Send us your issues, pull requests or suggestions.

## License

[MIT](http://opensource.org/licenses/MIT)

[hugo]: https://gohugo.io/
