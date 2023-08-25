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
use Dotclear\Core\Backend\Filter\Filter;
use Dotclear\Core\Backend\Page;
use Dotclear\Helper\File\Files;
use Dotclear\Helper\Html\Form\Form;

class BackendBehaviors
{
    public static function postHeaders()
    {
        return
        Page::jsJson('featuredmedia', ['confirm_remove_featuredmedia' => __('Are you sure you want to remove featured media "%s"?')]) .
        My::jsLoad('post.js');
    }

    public static function adminPostFormItems($main, $sidebar, $post)
    {
        if ($post !== null) {
            $post_media = dcCore::app()->media->getPostMedia((int) $post->post_id, null, 'featured');
            $nb_media   = count($post_media);
            $title      = __('Featured media');
            $item       = '<h5 class="clear s-featuredmedia">' . $title . '</h5>';
            foreach ($post_media as $f) {
                $ftitle = $f->media_title;
                if (strlen($ftitle) > 18) {
                    $ftitle = substr($ftitle, 0, 16) . '...';
                }
                $item .= '<div class="media-item s-featuredmedia">' .
                '<a class="media-icon" href="' . dcCore::app()->admin->url->get('admin.media.item', ['id' => $f->media_id]) . '">' .
                '<img src="' . $f->media_icon . '" alt="" title="' . $f->basename . '" /></a>' .
                '<ul>' .
                '<li><a class="media-link" href="' . dcCore::app()->admin->url->get('admin.media.item', ['id' => $f->media_id]) . '" ' .
                'title="' . $f->basename . '">' . $ftitle . '</a></li>' .
                '<li>' . $f->media_dtstr . '</li>' .
                '<li>' . Files::size($f->size) . ' - ' .
                '<a href="' . $f->file_url . '">' . __('open') . '</a>' . '</li>' .

                '<li class="media-action"><a class="featuredmedia-remove" id="featuredmedia-' . $f->media_id . '" ' .
                'href="' . dcCore::app()->admin->url->get('admin.post.media', [
                    'post_id'   => $post->post_id,
                    'media_id'  => $f->media_id,
                    'link_type' => 'featured',
                    'remove'    => '1',
                ]) . '">' .
                '<img src="images/trash.png" alt="' . __('remove') . '" /></a>' .
                    '</li>' .

                    '</ul>' .
                    '</div>';
            }
            unset($f);

            if (empty($post_media)) {
                $item .= '<p class="form-note s-featuredmedia">' . __('No featured media.') . '</p>';
            }
            if (!$nb_media) {
                $item .= '<p class="s-featuredmedia"><a class="button" href="' . dcCore::app()->admin->url->get('admin.media', ['post_id' => $post->post_id, 'link_type' => 'featured']) . '">' .
                __('Add a featured media for this entry') . '</a></p>';
            }
            $sidebar['metas-box']['items']['featuredmedia'] = $item;
        }
    }

    public static function adminPostAfterForm($post)
    {
        if ($post !== null) {
            echo (new Form('featuredmedia-remove-hide'))
                ->action(dcCore::app()->admin->url->get('admin.post.media'))
                ->method('post')
                ->fields([
                    ... My::hiddenFields([
                        'post_id'   => $post->post_id,
                        'media_id'  => '',
                        'link_type' => 'featured',
                        'remove'    => '1',
                    ]),
                ])
            ->render();
        }
    }

    public static function adminPostFilter(ArrayObject $filters)
    {
        $filters->append((new Filter('featuredmedia'))
            ->param('media')
            ->param('link_type', 'featured')
            ->title(__('Featured media:'))
            ->options([
                '-'                          => '',
                __('With featured media')    => '1',
                __('Without featured media') => '0',
            ]));
    }
}
