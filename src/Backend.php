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

class Backend extends dcNsProcess
{
    public static function init(): bool
    {
        static::$init = My::checkContext(My::BACKEND);

        // dead but useful code, in order to have translations
        __('featuredMedia') . __('featuredMedia');

        return static::$init;
    }

    public static function process(): bool
    {
        if (!static::$init) {
            return false;
        }

        dcCore::app()->addBehaviors([
            'adminPostFormItems' => [BackendBehaviors::class, 'adminPostFormItems'],
            'adminPostAfterForm' => [BackendBehaviors::class, 'adminPostAfterForm'],
            'adminPostHeaders'   => [BackendBehaviors::class, 'postHeaders'],
            'adminPostFilterV2'  => [BackendBehaviors::class, 'adminPostFilter'],

            'adminPageFormItems' => [BackendBehaviors::class, 'adminPostFormItems'],
            'adminPageAfterForm' => [BackendBehaviors::class, 'adminPostAfterForm'],
            'adminPageHeaders'   => [BackendBehaviors::class, 'postHeaders'],
        ]);

        return true;
    }
}
