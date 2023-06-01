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
use dcNsProcess;

class Frontend extends dcNsProcess
{
    public static function init(): bool
    {
        static::$init = My::checkContext(My::FRONTEND);

        return static::$init;
    }

    public static function process(): bool
    {
        if (!static::$init) {
            return false;
        }

        dcCore::app()->tpl->addBlock('FeaturedMedia', [FrontendTemplate::class, 'featuredMedia']);
        dcCore::app()->tpl->addValue('FeaturedMediaMimeType', [FrontendTemplate::class, 'featuredMediaMimeType']);
        dcCore::app()->tpl->addValue('FeaturedMediaType', [FrontendTemplate::class, 'featuredMediaType']);
        dcCore::app()->tpl->addValue('FeaturedMediaFileName', [FrontendTemplate::class, 'featuredMediaFileName']);
        dcCore::app()->tpl->addValue('FeaturedMediaSize', [FrontendTemplate::class, 'featuredMediaSize']);
        dcCore::app()->tpl->addValue('FeaturedMediaTitle', [FrontendTemplate::class, 'featuredMediaTitle']);
        dcCore::app()->tpl->addValue('FeaturedMediaThumbnailURL', [FrontendTemplate::class, 'featuredMediaThumbnailURL']);
        dcCore::app()->tpl->addValue('FeaturedMediaImageURL', [FrontendTemplate::class, 'featuredMediaImageURL']);
        dcCore::app()->tpl->addValue('FeaturedMediaURL', [FrontendTemplate::class, 'featuredMediaURL']);

        dcCore::app()->tpl->addBlock('FeaturedMediaIf', [FrontendTemplate::class, 'featuredMediaIf']);

        dcCore::app()->addBehaviors([
            'tplIfConditions' => [FrontendBehaviors::class, 'tplIfConditions'],
            'socialMetaMedia' => [FrontendBehaviors::class, 'socialMetaMedia'],
        ]);

        return true;
    }
}
