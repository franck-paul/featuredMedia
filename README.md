Implementation sample

[![Release](https://img.shields.io/github/v/release/franck-paul/featuredMedia)](https://github.com/franck-paul/featuredMedia/releases)
[![Date](https://img.shields.io/github/release-date/franck-paul/featuredMedia)](https://github.com/franck-paul/featuredMedia/releases)
[![Issues](https://img.shields.io/github/issues/franck-paul/featuredMedia)](https://github.com/franck-paul/featuredMedia/issues)
[![Dotclear](https://img.shields.io/badge/dotclear-v2.24-blue.svg)](https://fr.dotclear.org/download)
[![Dotaddict](https://img.shields.io/badge/dotaddict-official-green.svg)](https://plugins.dotaddict.org/dc2/details/featuredMedia)
[![License](https://img.shields.io/github/license/franck-paul/featuredMedia)](https://github.com/franck-paul/featuredMedia/blob/master/LICENSE)

=====================

```html
<!-- # Featured media -->
<tpl:FeaturedMedia>
  <div class="post-featured-media" id="featured-media {{tpl:FeaturedMediaType}}">
    <tpl:FeaturedMediaIf is_audio="1">
      {{tpl:include src="_audio_player.html"}}
    </tpl:FeaturedMediaIf>
    <tpl:FeaturedMediaIf is_video="1">
      {{tpl:include src="_video_player.html"}}
    </tpl:FeaturedMediaIf>
    <tpl:FeaturedMediaIf is_image="1">
      <img src="{{tpl:FeaturedMediaImageURL size="m"}}" alt="{{tpl:FeaturedMediaTitle}}" />
    </tpl:FeaturedMediaIf>
  </div>
</tpl:FeaturedMedia>
```
