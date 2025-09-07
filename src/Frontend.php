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

use Dotclear\App;
use Dotclear\Helper\Process\TraitProcess;

class Frontend
{
    use TraitProcess;

    public static function init(): bool
    {
        return self::status(My::checkContext(My::FRONTEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        App::frontend()->template()->addBlock('FeaturedMedia', FrontendTemplate::featuredMedia(...));
        App::frontend()->template()->addValue('FeaturedMediaMimeType', FrontendTemplate::featuredMediaMimeType(...));
        App::frontend()->template()->addValue('FeaturedMediaType', FrontendTemplate::featuredMediaType(...));
        App::frontend()->template()->addValue('FeaturedMediaFileName', FrontendTemplate::featuredMediaFileName(...));
        App::frontend()->template()->addValue('FeaturedMediaSize', FrontendTemplate::featuredMediaSize(...));
        App::frontend()->template()->addValue('FeaturedMediaTitle', FrontendTemplate::featuredMediaTitle(...));
        App::frontend()->template()->addValue('FeaturedMediaThumbnailURL', FrontendTemplate::featuredMediaThumbnailURL(...));
        App::frontend()->template()->addValue('FeaturedMediaImageURL', FrontendTemplate::featuredMediaImageURL(...));
        App::frontend()->template()->addValue('FeaturedMediaURL', FrontendTemplate::featuredMediaURL(...));

        App::frontend()->template()->addBlock('FeaturedMediaIf', FrontendTemplate::featuredMediaIf(...));

        App::behavior()->addBehaviors([
            'tplIfConditions' => FrontendBehaviors::tplIfConditions(...),
            'socialMetaMedia' => FrontendBehaviors::socialMetaMedia(...),
        ]);

        return true;
    }
}
