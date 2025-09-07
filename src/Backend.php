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

class Backend
{
    use TraitProcess;

    public static function init(): bool
    {
        // dead but useful code, in order to have translations
        __('featuredMedia');
        __('featuredMedia');

        return self::status(My::checkContext(My::BACKEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        App::behavior()->addBehaviors([
            'adminPostFormItems' => BackendBehaviors::adminPostFormItems(...),
            'adminPostAfterForm' => BackendBehaviors::adminPostAfterForm(...),
            'adminPostHeaders'   => BackendBehaviors::postHeaders(...),
            'adminPostFilterV2'  => BackendBehaviors::adminPostFilter(...),

            'adminPageFormItems' => BackendBehaviors::adminPostFormItems(...),
            'adminPageAfterForm' => BackendBehaviors::adminPostAfterForm(...),
            'adminPageHeaders'   => BackendBehaviors::postHeaders(...),
        ]);

        return true;
    }
}
