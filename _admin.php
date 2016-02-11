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
if (!defined('DC_CONTEXT_ADMIN')) { return; }

$core->addBehavior('adminPostFormItems',array('featuredMediaAdmin','adminPostFormItems'));
$core->addBehavior('adminPostAfterForm',array('featuredMediaAdmin','adminPostAfterForm'));
$core->addBehavior('adminPostHeaders',array('featuredMediaAdmin','postHeaders'));

$core->addBehavior('adminPageFormItems',array('featuredMediaAdmin','adminPostFormItems'));
$core->addBehavior('adminPageAfterForm',array('featuredMediaAdmin','adminPostAfterForm'));
$core->addBehavior('adminPageHeaders',array('featuredMediaAdmin','postHeaders'));

class featuredMediaAdmin
{
	public static function postHeaders()
	{
		$core =& $GLOBALS['core'];
		return
			'<script type="text/javascript">'."\n"."//<![CDATA[\n".
				dcPage::jsVar('dotclear.msg.confirm_remove_featuredmedia',
					__('Are you sure you want to remove featured media "%s"?')).
			"\n//]]>\n"."</script>\n".
			dcPage::jsLoad(dcPage::getPF('featuredMedia/js/post.js'));
	}

	public static function adminPostFormItems($main,$sidebar,$post)
	{
		if ($post !== null)
		{
			$core =& $GLOBALS['core'];
			$post_media = $core->media->getPostMedia($post->post_id,null,'featured');
			$nb_media = count($post_media);
			$title = __('Featured media');
			$item = '<h5 class="clear s-featuredmedia">'.$title.'</h5>';
			foreach ($post_media as $f)
			{
				$ftitle = $f->media_title;
				if (strlen($ftitle) > 18) {
					$ftitle = substr($ftitle,0,16).'...';
				}
				$item .=
				'<div class="media-item s-featuredmedia">'.
				'<a class="media-icon" href="'.$core->adminurl->get('admin.media.item',array('id' => $f->media_id)).'">'.
				'<img src="'.$f->media_icon.'" alt="" title="'.$f->basename.'" /></a>'.
				'<ul>'.
				'<li><a class="media-link" href="'.$core->adminurl->get('admin.media.item',array('id' => $f->media_id)).'" '.
				'title="'.$f->basename.'">'.$ftitle.'</a></li>'.
				'<li>'.$f->media_dtstr.'</li>'.
				'<li>'.files::size($f->size).' - '.
				'<a href="'.$f->file_url.'">'.__('open').'</a>'.'</li>'.

				'<li class="media-action"><a class="featuredmedia-remove" id="featuredmedia-'.$f->media_id.'" '.
				'href="'.$core->adminurl->get('admin.post.media',array(
					'post_id' => $post->post_id,
					'media_id' => $f->media_id,
					'link_type' => 'featured',
					'remove' => '1'
					)).'">'.
				'<img src="images/trash.png" alt="'.__('remove').'" /></a>'.
				'</li>'.

				'</ul>'.
				'</div>';
			}
			unset($f);

			if (empty($post_media)) {
				$item .= '<p class="form-note s-featuredmedia">'.__('No featured media.').'</p>';
			}
			if (!$nb_media) {
				$item .=
					'<p class="s-featuredmedia"><a class="button" href="'.$core->adminurl->get('admin.media',array('post_id' => $post->post_id, 'link_type' => 'featured')).'">'.
					__('Add a featured media for this entry').'</a></p>';
			}
			$sidebar['metas-box']['items']['featuredmedia']= $item;
		}
	}

	public static function adminPostAfterForm($post) {
		if ($post !== null)
		{
			$core =& $GLOBALS['core'];
			echo
				'<form action="'.$core->adminurl->get('admin.post.media').'" id="featuredmedia-remove-hide" method="post">'.
				'<div>'.form::hidden(array('post_id'),$post->post_id).
				form::hidden(array('media_id'),'').
				form::hidden(array('link_type'),'featured').
				form::hidden(array('remove'),1).
				$core->formNonce().'</div></form>';
		}
	}
}
