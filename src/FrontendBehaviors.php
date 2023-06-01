<?php
/**
 * @brief featuredMedia, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Plugin\featuredMedia;

use ArrayObject;
use dcCore;

class FrontendBehaviors
{
    public static function tplIfConditions($tag, $attr, $content, $if)
    {
        if ($tag == 'EntryIf' && isset($attr['has_featured_media'])) {
            $sign = (bool) $attr['has_featured_media'] ? '' : '!';
            $if[] = $sign . 'dcCore::app()->ctx->posts->countMedia(\'featured\')';
        }
    }

    public static function socialMetaMedia($media)
    {
        if (dcCore::app()->ctx->posts !== null && dcCore::app()->media) {
            $featured = new ArrayObject(dcCore::app()->media->getPostMedia(dcCore::app()->ctx->posts->post_id, null, 'featured'));
            foreach ($featured as $featured_f) {
                if ($featured_f->media_image) {
                    $media['img']   = $featured_f->file_url;
                    $media['alt']   = $featured_f->media_title;
                    $media['large'] = dcCore::app()->blog->settings->socialMeta->photo;
                    // First attached image found, return
                    return;
                }
            }
        }
    }
}
