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

use dcCore;
use dcTemplate;
use Dotclear\Helper\File\Files;

class FrontendTemplate
{
    /*dtd
    <!ELEMENT tpl:featuredMedia - - -- Post featured media -->
    <!ATTLIST tpl;featuredMedia
    size    CDATA    #IMPLIED    -- Image size ('sq','t','s','m','o', original by default or if no thumbnail requested)
    >
     */
    public static function featuredMedia($attr, $content)
    {
        $res = <<<TPLFM_TOP
            <?php
              if (dcCore::app()->ctx->posts !== null && dcCore::app()->media) {
                dcCore::app()->ctx->featured = new ArrayObject(dcCore::app()->media->getPostMedia(dcCore::app()->ctx->posts->post_id,null,"featured"));
                foreach (dcCore::app()->ctx->featured as \$featured_i => \$featured_f) :
                  dcCore::app()->ctx->featured_i = \$featured_i;
                  dcCore::app()->ctx->featured_f = \$featured_f;
                  dcCore::app()->ctx->file_url = \$featured_f->file_url;  // for Flash/HTML5 Players
            ?>
            TPLFM_TOP;
        $res .= $content;
        $res .= <<<TPLFM_END
            <?php
                endforeach;
                dcCore::app()->ctx->featured = null;
                unset(dcCore::app()->ctx->featured_i,dcCore::app()->ctx->featured_f,dcCore::app()->ctx->featured_url);
              }
            ?>
            TPLFM_END;

        return $res;
    }

    /*dtd
    <!ELEMENT tpl:featuredMediaIf - - -- Test on featured media fields -->
    <!ATTLIST tpl:featuredMediaIf
    is_image    (0|1)    #IMPLIED    -- test if featured media is an image (value : 1) or not (value : 0)
    has_thumb    (0|1)    #IMPLIED    -- test if featured media has a square thumbnail (value : 1) or not (value : 0)
    has_size    ('sq','t','s','m')    -- test if featured media has the requested thumbnail size or not
    is_audio    (0|1)    #IMPLIED    -- test if featured media is an audio file (value : 1) or not (value : 0)
    is_video    (0|1)    #IMPLIED    -- test if featured media is a video file (value : 1) or not (value : 0)
    is_mp3        (0|1)    #IMPLIED    -- test if attachment is a mp3 file (value : 1) or not (value : 0)
    is_flv        (0|1)    #IMPLIED    -- test if attachment is a flv file (value : 1) or not (value : 0)
    >
     */
    public static function featuredMediaIf($attr, $content)
    {
        $if = [];

        $operator = isset($attr['operator']) ? dcTemplate::getOperator($attr['operator']) : '&&';

        if (isset($attr['is_image'])) {
            $sign = (bool) $attr['is_image'] ? '' : '!';
            $if[] = $sign . '$featured_f->media_image';
        }

        if (isset($attr['has_thumb'])) {
            $sign = (bool) $attr['has_thumb'] ? '' : '!';
            $if[] = $sign . 'isset($featured_f->media_thumb[\'sq\'])';
        }

        if (isset($attr['has_size'])) {
            $if[] = 'isset($featured_f->media_thumb[\'' . $attr['has_size'] . '\'])';
        }

        if (isset($attr['is_audio'])) {
            $sign = (bool) $attr['is_audio'] ? '==' : '!=';
            $if[] = '$featured_f->type_prefix ' . $sign . ' "audio"';
        }

        if (isset($attr['is_video'])) {
            // Since 2.15 .flv media are no more considered as video (Flash is obsolete)
            $sign = (bool) $attr['is_video'] ? '==' : '!=';
            $test = '$featured_f->type_prefix ' . $sign . ' "video"';
            if ($sign == '==') {
                $test .= ' && $featured_f->type != "video/x-flv"';
            } else {
                $test .= ' || $featured_f->type == "video/x-flv"';
            }
            $if[] = $test;
        }

        if (isset($attr['is_mp3'])) {
            $sign = (bool) $attr['is_mp3'] ? '==' : '!=';
            $if[] = '$featured_f->type ' . $sign . ' "audio/mpeg3"';
        }

        if (isset($attr['is_flv'])) {
            $sign = (bool) $attr['is_flv'] ? '==' : '!=';
            $if[] = '$featured_f->type ' . $sign . ' "video/x-flv"';
        }

        if (count($if)) {
            return '<?php if(' . implode(' ' . $operator . ' ', $if) . ') : ?>' . $content . '<?php endif; ?>';
        }

        return $content;
    }

    /*dtd
    <!ELEMENT tpl:featuredMediaMimeType - O -- featured media MIME Type -->
     */
    public static function featuredMediaMimeType($attr)
    {
        $f = dcCore::app()->tpl->getFilters($attr);

        return '<?php echo ' . sprintf($f, '$featured_f->type') . '; ?>';
    }

    /*dtd
    <!ELEMENT tpl:featuredMediaType - O -- featured media type -->
     */
    public static function featuredMediaType($attr)
    {
        $f = dcCore::app()->tpl->getFilters($attr);

        return '<?php echo ' . sprintf($f, '$featured_f->media_type') . '; ?>';
    }

    /*dtd
    <!ELEMENT tpl:featuredMediaFileName - O -- featured media file name -->
     */
    public static function featuredMediaFileName($attr)
    {
        $f = dcCore::app()->tpl->getFilters($attr);

        return '<?php echo ' . sprintf($f, '$featured_f->basename') . '; ?>';
    }

    /*dtd
    <!ELEMENT tpl:featuredMediaSize - O -- featured media size -->
    <!ATTLIST tpl:featuredMediaSize
    full    CDATA    #IMPLIED    -- if set, size is rounded to a human-readable value (in KB, MB, GB, TB)
    >
     */
    public static function featuredMediaSize($attr)
    {
        $f = dcCore::app()->tpl->getFilters($attr);
        if (!empty($attr['full'])) {
            return '<?php echo ' . sprintf($f, '$featured_f->size') . '; ?>';
        }

        return '<?php echo ' . sprintf($f, Files::class . '::size($featured_f->size)') . '; ?>';
    }

    /*dtd
    <!ELEMENT tpl:featuredMediaTitle - O -- featured media title -->
     */
    public static function featuredMediaTitle($attr)
    {
        $f = dcCore::app()->tpl->getFilters($attr);

        return '<?php echo ' . sprintf($f, '$featured_f->media_title') . '; ?>';
    }

    /*dtd
    <!ELEMENT tpl:featuredMediaThumbnailURL - O -- featured media square thumbnail URL -->
     */
    public static function featuredMediaThumbnailURL($attr)
    {
        $f = dcCore::app()->tpl->getFilters($attr);

        return
        '<?php ' . "\n" .
        'if (isset($featured_f->media_thumb[\'sq\'])) {' . "\n" .
        '   $url = $featured_f->media_thumb[\'sq\']);' . "\n" .
        '   if (substr($url, 0, strlen(dcCore::app()->blog->host)) === dcCore::app()->blog->host) {' . "\n" .
        '       $url = substr($url, strlen(dcCore::app()->blog->host));' . "\n" .
        '   }' . "\n" .
        '   echo ' . sprintf($f, '$url') . ';' . "\n" .
        '}' .
        '?>';
    }

    /*dtd
    <!ELEMENT tpl:featuredMediaImageURL - O -- featured media image URL -->
    <!ATTLIST tpl:featuredMediaImageURL
    size    CDATA    #IMPLIED    -- Image size ('sq','t','s','m','o', original by default or if no thumbnail requested)
     */
    public static function featuredMediaImageURL($attr)
    {
        $f = dcCore::app()->tpl->getFilters($attr);
        if (empty($attr['size'])) {
            return self::featuredMediaURL($attr);
        }

        return
        '<?php ' . "\n" .
        'if (isset($featured_f->media_thumb[\'' . $attr['size'] . '\'])) {' . "\n" .
        '   $url = $featured_f->media_thumb[\'' . $attr['size'] . '\'];' . "\n" .
        '} else {' . "\n" .
        '   $url = $featured_f->file_url;' . "\n" .
        '}' . "\n" .
        'if (substr($url, 0, strlen(dcCore::app()->blog->host)) === dcCore::app()->blog->host) {' . "\n" .
        '   $url = substr($url, strlen(dcCore::app()->blog->host));' . "\n" .
        '}' . "\n" .
        'echo ' . sprintf($f, '$url') . ';' . "\n" .
        '?>';
    }

    /*dtd
    <!ELEMENT tpl:featuredMediaURL - O -- featured media URL -->
     */
    public static function featuredMediaURL($attr)
    {
        $f = dcCore::app()->tpl->getFilters($attr);

        return
        '<?php ' . "\n" .
        '$url = $featured_f->file_url;' . "\n" .
        'if (substr($url, 0, strlen(dcCore::app()->blog->host)) === dcCore::app()->blog->host) {' . "\n" .
        '   $url = substr($url, strlen(dcCore::app()->blog->host));' . "\n" .
        '}' . "\n" .
        'echo ' . sprintf($f, '$url') . ';' . "\n" .
        '?>';
    }
}
