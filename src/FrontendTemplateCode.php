<?php

/**
 * @brief featuredMedia, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul contact@open-time.net
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Plugin\featuredMedia;

use ArrayObject;
use Dotclear\App;

class FrontendTemplateCode
{
    /**
     * PHP code for tpl:FeaturedMedia block
     */
    public static function featuredMedia(
        string $_content_HTML
    ): void {
        if (App::frontend()->context()->posts instanceof \Dotclear\Database\MetaRecord) {
            $featured_media_post_id = is_numeric($featured_media_post_id = App::frontend()->context()->posts->post_id) ? (int) $featured_media_post_id : 0;
            if ($featured_media_post_id > 0) {
                App::frontend()->context()->featured = new ArrayObject(App::media()->getPostMedia($featured_media_post_id, null, 'featured'));
                foreach (App::frontend()->context()->featured as $featured_i => $featured_f) :
                    App::frontend()->context()->featured_i = $featured_i;
                    App::frontend()->context()->featured_f = $featured_f;
                    App::frontend()->context()->file_url   = $featured_f->file_url;  // for HTML5 Players
                    ?>
            $_content_HTML
            <?php endforeach;
                App::frontend()->context()->featured = null;
                unset(
                    App::frontend()->context()->featured_i,
                    App::frontend()->context()->featured_f,
                    App::frontend()->context()->featured_url
                );
            }
            unset($featured_media_post_id);
        }
    }

    /**
     * PHP code for tpl:EntryMyMetaIf block
     */
    public static function featuredMediaIf(
        string $_test_HTML,
        string $_content_HTML,
    ): void {
        /* @phpstan-ignore-next-line */
        if (($_test_HTML) === true) : ?>
            $_content_HTML
        <?php endif;
    }

    /**
     * PHP code for tpl:FeaturedMediaMimeType value
     *
     * @param      array<int|string, mixed>     $_params_  The parameters
     */
    public static function featuredMediaMimeType(
        array $_params_,
        string $_tag_
    ): void {
        if (App::frontend()->context()->featured_f instanceof \Dotclear\Helper\File\MediaFile) {
            echo App::frontend()->context()::global_filters(
                App::frontend()->context()->featured_f->type,
                $_params_,
                $_tag_
            );
        }
    }

    /**
     * PHP code for tpl:FeaturedMediaType value
     *
     * @param      array<int|string, mixed>     $_params_  The parameters
     */
    public static function featuredMediaType(
        array $_params_,
        string $_tag_
    ): void {
        if (App::frontend()->context()->featured_f instanceof \Dotclear\Helper\File\MediaFile) {
            echo App::frontend()->context()::global_filters(
                App::frontend()->context()->featured_f->media_type,
                $_params_,
                $_tag_
            );
        }
    }

    /**
     * PHP code for tpl:FeaturedMediaFileName value
     *
     * @param      array<int|string, mixed>     $_params_  The parameters
     */
    public static function featuredMediaFileName(
        array $_params_,
        string $_tag_
    ): void {
        if (App::frontend()->context()->featured_f instanceof \Dotclear\Helper\File\MediaFile) {
            echo App::frontend()->context()::global_filters(
                App::frontend()->context()->featured_f->basename,
                $_params_,
                $_tag_
            );
        }
    }

    /**
     * PHP code for tpl:FeaturedMediaSize value
     *
     * @param      array<int|string, mixed>     $_params_  The parameters
     */
    public static function featuredMediaSize(
        bool $_full_,
        array $_params_,
        string $_tag_
    ): void {
        if (App::frontend()->context()->featured_f instanceof \Dotclear\Helper\File\MediaFile) {
            $featured_media_size = App::frontend()->context()->featured_f->size;
            echo App::frontend()->context()::global_filters(
                $_full_ ? \Dotclear\Helper\File\Files::size($featured_media_size) : (string) $featured_media_size,
                $_params_,
                $_tag_
            );
            unset($featured_media_size);
        }
    }

    /**
     * PHP code for tpl:FeaturedMediaTitle value
     *
     * @param      array<int|string, mixed>     $_params_  The parameters
     */
    public static function featuredMediaTitle(
        array $_params_,
        string $_tag_
    ): void {
        if (App::frontend()->context()->featured_f instanceof \Dotclear\Helper\File\MediaFile) {
            echo App::frontend()->context()::global_filters(
                App::frontend()->context()->featured_f->media_title,
                $_params_,
                $_tag_
            );
        }
    }

    /**
     * PHP code for tpl:FeaturedMediaAlt value
     *
     * @param      array<int|string, mixed>     $_params_  The parameters
     */
    public static function featuredMediaAlt(
        array $_params_,
        string $_tag_
    ): void {
        if (App::frontend()->context()->featured_f instanceof \Dotclear\Helper\File\MediaFile) {
            echo App::frontend()->context()::global_filters(
                App::media()->getMediaAlt(App::frontend()->context()->featured_f),
                $_params_,
                $_tag_
            );
        }
    }

    /**
     * PHP code for tpl:FeaturedMediaLegend value
     *
     * @param      array<int|string, mixed>     $_params_  The parameters
     */
    public static function featuredMediaLegend(
        array $_params_,
        string $_tag_
    ): void {
        if (App::frontend()->context()->featured_f instanceof \Dotclear\Helper\File\MediaFile) {
            echo App::frontend()->context()::global_filters(
                App::media()->getMediaLegend(App::frontend()->context()->featured_f, no_date_alone: true),
                $_params_,
                $_tag_
            );
        }
    }

    /**
     * PHP code for tpl:FeaturedMediaThumbnailURL value
     *
     * @param      array<int|string, mixed>     $_params_  The parameters
     */
    public static function featuredMediaThumbnailURL(
        array $_params_,
        string $_tag_
    ): void {
        if (App::frontend()->context()->featured_f instanceof \Dotclear\Helper\File\MediaFile && isset(App::frontend()->context()->featured_f->media_thumb['sq'])) {
            $featured_media_url = App::frontend()->context()->featured_f->media_thumb['sq'];
            if (str_starts_with($featured_media_url, (string) App::blog()->host())) {
                $featured_media_url = substr($featured_media_url, strlen((string) App::blog()->host()));
            }
            echo App::frontend()->context()::global_filters(
                $featured_media_url,
                $_params_,
                $_tag_
            );
            unset($featured_media_url);
        }
    }

    /**
     * PHP code for tpl:FeaturedMediaImageURL value
     *
     * @param      array<int|string, mixed>     $_params_  The parameters
     */
    public static function featuredMediaImageURL(
        string $_size_,
        array $_params_,
        string $_tag_
    ): void {
        if (App::frontend()->context()->featured_f instanceof \Dotclear\Helper\File\MediaFile) {
            if (isset(App::frontend()->context()->featured_f->media_thumb[$_size_])) {
                $featured_media_url = App::frontend()->context()->featured_f->media_thumb[$_size_];
            } else {
                $featured_media_url = App::frontend()->context()->featured_f->file_url;
            }
            if (str_starts_with((string) $featured_media_url, (string) App::blog()->host())) {
                $featured_media_url = substr((string) $featured_media_url, strlen((string) App::blog()->host()));
            }
            echo App::frontend()->context()::global_filters(
                $featured_media_url,
                $_params_,
                $_tag_
            );
            unset($featured_media_url);
        }
    }

    /**
     * PHP code for tpl:FeaturedMediaURL value
     *
     * @param      array<int|string, mixed>     $_params_  The parameters
     */
    public static function featuredMediaURL(
        array $_params_,
        string $_tag_
    ): void {
        if (App::frontend()->context()->featured_f instanceof \Dotclear\Helper\File\MediaFile) {
            $featured_media_url = App::frontend()->context()->featured_f->file_url;
            if (str_starts_with((string) $featured_media_url, (string) App::blog()->host())) {
                $featured_media_url = substr((string) $featured_media_url, strlen((string) App::blog()->host()));
            }
            echo App::frontend()->context()::global_filters(
                $featured_media_url,
                $_params_,
                $_tag_
            );
            unset($featured_media_url);
        }
    }
}
