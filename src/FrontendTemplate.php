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
use Dotclear\Core\Frontend\Tpl;
use Dotclear\Plugin\TemplateHelper\Code;

class FrontendTemplate
{
    /*dtd
      <!ELEMENT tpl:FeaturedMedia - - -- Post featured media -->
      >
       */

    /**
     * @param      array<string, mixed>|\ArrayObject<string, mixed>  $attr      The attribute
     * @param      string                                            $content   The content
     */
    public static function featuredMedia(array|ArrayObject $attr, string $content): string
    {
        $attr = $attr instanceof ArrayObject ? $attr : new ArrayObject($attr);

        return Code::getPHPTemplateBlockCode(
            FrontendTemplateCode::featuredMedia(...),
            [],
            $content,
            $attr,
        );
    }

    /*dtd
      <!ELEMENT tpl:FeaturedMediaIf - - -- Test on featured media fields -->
      <!ATTLIST tpl:FeaturedMediaIf
      is_image    (0|1)    #IMPLIED    -- test if featured media is an image (value : 1) or not (value : 0)
      has_thumb    (0|1)    #IMPLIED    -- test if featured media has a square thumbnail (value : 1) or not (value : 0)
      has_size    ('sq','t','s','m')    -- test if featured media has the requested thumbnail size or not
      is_audio    (0|1)    #IMPLIED    -- test if featured media is an audio file (value : 1) or not (value : 0)
      is_video    (0|1)    #IMPLIED    -- test if featured media is a video file (value : 1) or not (value : 0)
      is_mp3        (0|1)    #IMPLIED    -- test if attachment is a mp3 file (value : 1) or not (value : 0)
      is_flv        (0|1)    #IMPLIED    -- test if attachment is a flv file (value : 1) or not (value : 0)
      >
       */

    /**
     * @param      array<string, mixed>|\ArrayObject<string, mixed>  $attr      The attribute
     * @param      string                                            $content   The content
     */
    public static function featuredMediaIf(array|ArrayObject $attr, string $content): string
    {
        $attr = $attr instanceof ArrayObject ? $attr : new ArrayObject($attr);

        /**
         * Warning: Take care of $featured_f variable used in template code
         * Should be renamed here if renamed in FrontendTemplateCode::featuredMediaIf() code.
         */
        $if = [];

        $operator = isset($attr['operator']) ? Tpl::getOperator($attr['operator']) : '&&';

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
            $sign = (bool) $attr['is_audio'] ? '===' : '!==';
            $if[] = '$featured_f->type_prefix ' . $sign . ' "audio"';
        }

        if (isset($attr['is_video'])) {
            // Since 2.15 .flv media are no more considered as video (Flash is obsolete)
            $sign = (bool) $attr['is_video'] ? '===' : '!==';
            $test = '$featured_f->type_prefix ' . $sign . ' "video"';
            if ($sign === '===') {
                $test .= ' && $featured_f->type !== "video/x-flv"';
            } else {
                $test .= ' || $featured_f->type === "video/x-flv"';
            }

            $if[] = $test;
        }

        if (isset($attr['is_mp3'])) {
            $sign = (bool) $attr['is_mp3'] ? '===' : '!==';
            $if[] = '$featured_f->type ' . $sign . ' "audio/mpeg3"';
        }

        if (isset($attr['is_flv'])) {
            $sign = (bool) $attr['is_flv'] ? '===' : '!==';
            $if[] = '$featured_f->type ' . $sign . ' "video/x-flv"';
        }

        $test = implode(' ' . $operator . ' ', $if);

        if ($if === []) {
            return '';
        }

        return Code::getPHPTemplateBlockCode(
            FrontendTemplateCode::featuredMediaIf(...),
            [
                $test,
            ],
            $content,
            $attr,
        );
    }

    /*dtd
      <!ELEMENT tpl:FeaturedMediaMimeType - O -- featured media MIME Type -->
       */

    /**
     * @param      array<string, mixed>|\ArrayObject<string, mixed>  $attr      The attribute
     */
    public static function featuredMediaMimeType(array|ArrayObject $attr): string
    {
        $attr = $attr instanceof ArrayObject ? $attr : new ArrayObject($attr);

        return Code::getPHPTemplateValueCode(
            FrontendTemplateCode::featuredMediaMimeType(...),
            attr: $attr,
        );
    }

    /*dtd
      <!ELEMENT tpl:FeaturedMediaType - O -- featured media type -->
       */

    /**
     * @param      array<string, mixed>|\ArrayObject<string, mixed>  $attr      The attribute
     */
    public static function featuredMediaType(array|ArrayObject $attr): string
    {
        $attr = $attr instanceof ArrayObject ? $attr : new ArrayObject($attr);

        return Code::getPHPTemplateValueCode(
            FrontendTemplateCode::featuredMediaType(...),
            attr: $attr,
        );
    }

    /*dtd
      <!ELEMENT tpl:FeaturedMediaFileName - O -- featured media file name -->
       */

    /**
     * @param      array<string, mixed>|\ArrayObject<string, mixed>  $attr      The attribute
     */
    public static function featuredMediaFileName(array|ArrayObject $attr): string
    {
        $attr = $attr instanceof ArrayObject ? $attr : new ArrayObject($attr);

        return Code::getPHPTemplateValueCode(
            FrontendTemplateCode::featuredMediaFileName(...),
            attr: $attr,
        );
    }

    /*dtd
      <!ELEMENT tpl:FeaturedMediaSize - O -- featured media size -->
      <!ATTLIST tpl:FeaturedMediaSize
      full    CDATA    #IMPLIED    -- if set, size is rounded to a human-readable value (in KB, MB, GB, TB)
      >
       */

    /**
     * @param      array<string, mixed>|\ArrayObject<string, mixed>  $attr      The attribute
     */
    public static function featuredMediaSize(array|ArrayObject $attr): string
    {
        $attr = $attr instanceof ArrayObject ? $attr : new ArrayObject($attr);

        return Code::getPHPTemplateValueCode(
            FrontendTemplateCode::featuredMediaFileName(...),
            [
                !empty($attr['full']),
            ],
            attr: $attr,
        );
    }

    /*dtd
      <!ELEMENT tpl:FeaturedMediaTitle - O -- featured media title -->
       */

    /**
     * @param      array<string, mixed>|\ArrayObject<string, mixed>  $attr      The attribute
     */
    public static function featuredMediaTitle(array|ArrayObject $attr): string
    {
        $attr = $attr instanceof ArrayObject ? $attr : new ArrayObject($attr);

        return Code::getPHPTemplateValueCode(
            FrontendTemplateCode::featuredMediaTitle(...),
            attr: $attr,
        );
    }

    /*dtd
      <!ELEMENT tpl:FeaturedMediaThumbnailURL - O -- featured media square thumbnail URL -->
       */

    /**
     * @param      array<string, mixed>|\ArrayObject<string, mixed>  $attr      The attribute
     */
    public static function featuredMediaThumbnailURL(array|ArrayObject $attr): string
    {
        $attr = $attr instanceof ArrayObject ? $attr : new ArrayObject($attr);

        return Code::getPHPTemplateValueCode(
            FrontendTemplateCode::featuredMediaThumbnailURL(...),
            attr: $attr,
        );
    }

    /*dtd
      <!ELEMENT tpl:FeaturedMediaImageURL - O -- featured media image URL -->
      <!ATTLIST tpl:FeaturedMediaImageURL
      size    CDATA    #IMPLIED    -- Image size ('sq','t','s','m','o', original by default or if no thumbnail requested)
       */

    /**
     * @param      array<string, mixed>|\ArrayObject<string, mixed>  $attr      The attribute
     */
    public static function featuredMediaImageURL(array|ArrayObject $attr): string
    {
        $attr = $attr instanceof ArrayObject ? $attr : new ArrayObject($attr);

        if (empty($attr['size'])) {
            return self::featuredMediaURL($attr);
        }

        return Code::getPHPTemplateValueCode(
            FrontendTemplateCode::featuredMediaImageURL(...),
            [
                (string) $attr['size'],
            ],
            attr: $attr,
        );
    }

    /*dtd
      <!ELEMENT tpl:FeaturedMediaURL - O -- featured media URL -->
       */

    /**
     * @param      array<string, mixed>|\ArrayObject<string, mixed>  $attr      The attribute
     */
    public static function featuredMediaURL(array|ArrayObject $attr): string
    {
        $attr = $attr instanceof ArrayObject ? $attr : new ArrayObject($attr);

        return Code::getPHPTemplateValueCode(
            FrontendTemplateCode::featuredMediaURL(...),
            attr: $attr,
        );
    }
}
