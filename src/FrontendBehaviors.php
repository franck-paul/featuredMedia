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
use Dotclear\App;

class FrontendBehaviors
{
    /**
     * Extends tpl:EntryIf attributes.
     *
     * attributes:
     *
     *      has_featured_media  (0|1)   Entry has an one or several featured media attachments (if 1), or not (if 0)
     *
     * @param   string                      $tag        The current tag
     * @param   ArrayObject<string, mixed>  $attr       The attributes
     * @param   string                      $content    The content
     * @param   ArrayObject<int, string>    $if         The conditions stack
     */
    public static function tplIfConditions($tag, $attr, $content, $if): string
    {
        if ($tag == 'EntryIf' && isset($attr['has_featured_media'])) {
            $sign = (bool) $attr['has_featured_media'] ? '' : '!';
            $if[] = $sign . 'App::frontend()->context()->posts->countMedia(\'featured\')';
        }

        return '';
    }

    /**
     * @param      ArrayObject<string, mixed>  $media  The media
     */
    public static function socialMetaMedia(ArrayObject $media): string
    {
        if (App::frontend()->context()->posts !== null) {
            $featured = new ArrayObject(App::media()->getPostMedia((int) App::frontend()->context()->posts->post_id, null, 'featured'));
            foreach ($featured as $featured_f) {
                if ($featured_f->media_image) {
                    $media['img']   = $featured_f->file_url;
                    $media['alt']   = $featured_f->media_title;
                    $media['large'] = App::blog()->settings()->get('socialMeta')->photo;

                    // First attached image found, return
                    return '';
                }
            }
        }

        return '';
    }
}
