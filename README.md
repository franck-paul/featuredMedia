Implementation sample
=====================

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
