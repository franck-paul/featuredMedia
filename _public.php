<?php
# -- BEGIN LICENSE BLOCK ---------------------------------------
#
# This file is part of featuredMedia, a plugin for Dotclear 2.
#
# Copyright (c) Franck Paul and contributors
# Licensed under the GPL version 2.0 license.
# See LICENSE file or
# http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
#
# -- END LICENSE BLOCK -----------------------------------------
if (!defined('DC_RC_PATH')) { return; }

$core->tpl->addBlock('FeaturedMedia',array('featuredMediaTpl','featuredMedia'));
$core->tpl->addValue('FeaturedMediaMimeType',array('featuredMediaTpl','featuredMediaMimeType'));
$core->tpl->addValue('FeaturedMediaType',array('featuredMediaTpl','featuredMediaType'));
$core->tpl->addValue('FeaturedMediaFileName',array('featuredMediaTpl','featuredMediaFileName'));
$core->tpl->addValue('FeaturedMediaSize',array('featuredMediaTpl','featuredMediaSize'));
$core->tpl->addValue('FeaturedMediaTitle',array('featuredMediaTpl','featuredMediaTitle'));
$core->tpl->addValue('FeaturedMediaThumbnailURL',array('featuredMediaTpl','featuredMediaThumbnailURL'));
$core->tpl->addValue('FeaturedMediaImageURL',array('featuredMediaTpl','featuredMediaImageURL'));
$core->tpl->addValue('FeaturedMediaURL',array('featuredMediaTpl','featuredMediaURL'));

$core->tpl->addBlock('FeaturedMediaIf',array('featuredMediaTpl','featuredMediaIf'));

$core->addBehavior('tplIfConditions',array('featuredMediaBehavior','tplIfConditions'));

class featuredMediaTpl {

	/*dtd
	<!ELEMENT tpl:featuredMedia - - -- Post featured media -->
	<!ATTLIST tpl;featuredMedia
	size	CDATA	#IMPLIED	-- Image size ('sq','t','s','m','o', original by default or if no thumbnail requested)
	>
	*/
	public static function featuredMedia($attr,$content)
	{
		$res =
		"<?php\n".
		'if ($_ctx->posts !== null && $core->media) {'."\n".
			'$_ctx->featured = new ArrayObject($core->media->getPostMedia($_ctx->posts->post_id,null,"featured"));'."\n".
		"?>\n".

		'<?php foreach ($_ctx->featured as $featured_i => $featured_f) : '.
		'$GLOBALS[\'featured_i\'] = $featured_i; $GLOBALS[\'featured_f\'] = $featured_f;'.
		'$_ctx->file_url = $featured_f->file_url; ?>'.	// for Flash/HTML5 Players
		$content.
		'<?php endforeach; $_ctx->featured = null; unset($featured_i,$featured_f,$_ctx->featured_url); ?>'.

		"<?php } ?>\n";

		return $res;
	}

	/*dtd
	<!ELEMENT tpl:featuredMediaIf - - -- Test on featured media fields -->
	<!ATTLIST tpl:featuredMediaIf
	is_image	(0|1)	#IMPLIED	-- test if featured media is an image (value : 1) or not (value : 0)
	has_thumb	(0|1)	#IMPLIED	-- test if featured media has a square thumbnail (value : 1) or not (value : 0)
	has_size	('sq','t','s','m')	-- test if featured media has the requested thumbnail size or not
	is_audio	(0|1)	#IMPLIED	-- test if featured media is an audio file (value : 1) or not (value : 0)
	is_video	(0|1)	#IMPLIED	-- test if featured media is a video file (value : 1) or not (value : 0)
	is_mp3		(0|1)	#IMPLIED	-- test if attachment is a mp3 file (value : 1) or not (value : 0)
	is_flv		(0|1)	#IMPLIED	-- test if attachment is a flv file (value : 1) or not (value : 0)
	>
	*/
	public static function featuredMediaIf($attr,$content)
	{
		$if = array();

		$operator = isset($attr['operator']) ? dcTemplate::getOperator($attr['operator']) : '&&';

		if (isset($attr['is_image'])) {
			$sign = (boolean) $attr['is_image'] ? '' : '!';
			$if[] = $sign.'$featured_f->media_image';
		}

		if (isset($attr['has_thumb'])) {
			$sign = (boolean) $attr['has_thumb'] ? '' : '!';
			$if[] = $sign.'isset($featured_f->media_thumb[\'sq\'])';
		}

		if (isset($attr['has_size'])) {
			$if[] = 'isset($featured_f->media_thumb[\''.$attr['has_size'].'\'])';
		}

		if (isset($attr['is_audio'])) {
			$sign = (boolean) $attr['is_audio'] ? '==' : '!=';
			$if[] = '$featured_f->type_prefix '.$sign.' "audio"';
		}

		if (isset($attr['is_video'])) {
			$sign = (boolean) $attr['is_video'] ? '==' : '!=';
			$if[] = '$featured_f->type_prefix '.$sign.' "video"';
		}

		if (isset($attr['is_mp3'])) {
			$sign = (boolean) $attr['is_mp3'] ? '==' : '!=';
			$if[] = '$featured_f->type '.$sign.' "audio/mpeg3"';
		}

		if (isset($attr['is_flv'])) {
			$sign = (boolean) $attr['is_flv'] ? '==' : '!=';
			$if[] = '$featured_f->type '.$sign.' "video/x-flv"';
		}


		if (count($if) != 0) {
			return '<?php if('.implode(' '.$operator.' ', (array) $if).') : ?>'.$content.'<?php endif; ?>';
		} else {
			return $content;
		}
	}

	/*dtd
	<!ELEMENT tpl:featuredMediaMimeType - O -- featured media MIME Type -->
	*/
	public static function featuredMediaMimeType($attr)
	{
		$f = $GLOBALS['core']->tpl->getFilters($attr);
		return '<?php echo '.sprintf($f,'$featured_f->type').'; ?>';
	}

	/*dtd
	<!ELEMENT tpl:featuredMediaType - O -- featured media type -->
	*/
	public static function featuredMediaType($attr)
	{
		$f = $GLOBALS['core']->tpl->getFilters($attr);
		return '<?php echo '.sprintf($f,'$featured_f->media_type').'; ?>';
	}

	/*dtd
	<!ELEMENT tpl:featuredMediaFileName - O -- featured media file name -->
	*/
	public static function featuredMediaFileName($attr)
	{
		$f = $GLOBALS['core']->tpl->getFilters($attr);
		return '<?php echo '.sprintf($f,'$featured_f->basename').'; ?>';
	}

	/*dtd
	<!ELEMENT tpl:featuredMediaSize - O -- featured media size -->
	<!ATTLIST tpl:featuredMediaSize
	full	CDATA	#IMPLIED	-- if set, size is rounded to a human-readable value (in KB, MB, GB, TB)
	>
	*/
	public static function featuredMediaSize($attr)
	{
		$f = $GLOBALS['core']->tpl->getFilters($attr);
		if (!empty($attr['full'])) {
			return '<?php echo '.sprintf($f,'$featured_f->size').'; ?>';
		}
		return '<?php echo '.sprintf($f,'files::size($featured_f->size)').'; ?>';
	}

	/*dtd
	<!ELEMENT tpl:featuredMediaTitle - O -- featured media title -->
	*/
	public static function featuredMediaTitle($attr)
	{
		$f = $GLOBALS['core']->tpl->getFilters($attr);
		return '<?php echo '.sprintf($f,'$featured_f->media_title').'; ?>';
	}

	/*dtd
	<!ELEMENT tpl:featuredMediaThumbnailURL - O -- featured media square thumbnail URL -->
	*/
	public static function featuredMediaThumbnailURL($attr)
	{
		$f = $GLOBALS['core']->tpl->getFilters($attr);
		return
		'<?php '.
		'if (isset($featured_f->media_thumb[\'sq\'])) {'.
			'echo '.sprintf($f,'$featured_f->media_thumb[\'sq\']').';'.
		'}'.
		'?>';
	}

	/*dtd
	<!ELEMENT tpl:featuredMediaImageURL - O -- featured media image URL -->
	<!ATTLIST tpl:featuredMediaImageURL
	size	CDATA	#IMPLIED	-- Image size ('sq','t','s','m','o', original by default or if no thumbnail requested)
	*/
	public static function featuredMediaImageURL($attr)
	{
		$f = $GLOBALS['core']->tpl->getFilters($attr);
		if (empty($attr['size'])) {
			return self::featuredMediaURL($attr);
		}
		return
		'<?php '.
		'if (isset($featured_f->media_thumb[\''.$attr['size'].'\'])) {'.
			'echo '.sprintf($f,'$featured_f->media_thumb[\''.$attr['size'].'\']').';'.
		'} else {'.
			'echo '.sprintf($f,'$featured_f->file_url').';'.
		'}'.
		'?>';
	}

	/*dtd
	<!ELEMENT tpl:featuredMediaURL - O -- featured media URL -->
	*/
	public static function featuredMediaURL($attr)
	{
		$f = $GLOBALS['core']->tpl->getFilters($attr);
		return '<?php echo '.sprintf($f,'$featured_f->file_url').'; ?>';
	}
}

class featuredMediaBehavior {
	public static function tplIfConditions($tag,$attr,$content,$if)
	{
		if ($tag == "EntryIf" && isset($attr['has_featured_media'])) {
			$sign = (boolean) $attr['has_featured_media'] ? '' : '!';
			$if[] = $sign.'$_ctx->posts->countMedia(\'featured\')';
		}
	}
}
