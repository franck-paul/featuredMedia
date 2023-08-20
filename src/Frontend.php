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
use Dotclear\Core\Process;

class Frontend extends Process
{
    public static function init(): bool
    {
        return self::status(My::checkContext(My::FRONTEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        dcCore::app()->tpl->addBlock('FeaturedMedia', FrontendTemplate::featuredMedia(...));
        dcCore::app()->tpl->addValue('FeaturedMediaMimeType', FrontendTemplate::featuredMediaMimeType(...));
        dcCore::app()->tpl->addValue('FeaturedMediaType', FrontendTemplate::featuredMediaType(...));
        dcCore::app()->tpl->addValue('FeaturedMediaFileName', FrontendTemplate::featuredMediaFileName(...));
        dcCore::app()->tpl->addValue('FeaturedMediaSize', FrontendTemplate::featuredMediaSize(...));
        dcCore::app()->tpl->addValue('FeaturedMediaTitle', FrontendTemplate::featuredMediaTitle(...));
        dcCore::app()->tpl->addValue('FeaturedMediaThumbnailURL', FrontendTemplate::featuredMediaThumbnailURL(...));
        dcCore::app()->tpl->addValue('FeaturedMediaImageURL', FrontendTemplate::featuredMediaImageURL(...));
        dcCore::app()->tpl->addValue('FeaturedMediaURL', FrontendTemplate::featuredMediaURL(...));

        dcCore::app()->tpl->addBlock('FeaturedMediaIf', FrontendTemplate::featuredMediaIf(...));

        dcCore::app()->addBehaviors([
            'tplIfConditions' => FrontendBehaviors::tplIfConditions(...),
            'socialMetaMedia' => FrontendBehaviors::socialMetaMedia(...),
        ]);

        return true;
    }
}
