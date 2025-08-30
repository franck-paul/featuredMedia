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
use Dotclear\Core\Backend\Page;
use Dotclear\Database\MetaRecord;
use Dotclear\Helper\File\Files;
use Dotclear\Helper\Html\Form\Div;
use Dotclear\Helper\Html\Form\Form;
use Dotclear\Helper\Html\Form\Hidden;
use Dotclear\Helper\Html\Form\Img;
use Dotclear\Helper\Html\Form\Li;
use Dotclear\Helper\Html\Form\Link;
use Dotclear\Helper\Html\Form\None;
use Dotclear\Helper\Html\Form\Note;
use Dotclear\Helper\Html\Form\Para;
use Dotclear\Helper\Html\Form\Set;
use Dotclear\Helper\Html\Form\Text;
use Dotclear\Helper\Html\Form\Ul;
use Dotclear\Helper\Stack\Filter;

class BackendBehaviors
{
    public static function postHeaders(): string
    {
        return
        Page::jsJson('featuredmedia', ['confirm_remove_featuredmedia' => __('Are you sure you want to remove featured media "%s"?')]) .
        My::cssLoad('post.css') .
        My::jsLoad('post.js');
    }

    /**
     * @param      ArrayObject<string, mixed>   $main     The main
     * @param      ArrayObject<string, mixed>   $sidebar  The sidebar
     * @param      MetaRecord|null              $post     The post
     */
    public static function adminPostFormItems(ArrayObject $main, ArrayObject $sidebar, ?MetaRecord $post): string
    {
        if ($post instanceof MetaRecord) {
            $post_media = App::media()->getPostMedia((int) $post->post_id, null, 'featured');
            $blocks     = [];

            if (empty($post_media)) {
                $blocks[] = (new Note())
                    ->class(['form-note', 's-featuredmedia'])
                    ->text(__('No featured media.'));
            } else {
                foreach ($post_media as $media) {
                    $ftitle    = $media->media_title;
                    $media_url = App::backend()->url()->get('admin.media.item', ['id' => $media->media_id]);
                    if (strlen((string) $ftitle) > 18) {
                        $ftitle = substr((string) $ftitle, 0, 17) . '…';
                    }

                    $blocks[] = (new Div())
                        ->class(['media-item', 's-featuredmedia'])
                        ->items([
                            (new Link())
                                ->class('media-icon')
                                ->href($media_url)
                                ->items([
                                    (new Img($media->media_icon))
                                        ->alt('')
                                        ->title($media->basename),
                                ]),
                            (new Ul())
                                ->items([
                                    (new Li())
                                        ->items([
                                            (new Link())
                                                ->class('media-link')
                                                ->href($media_url)
                                                ->title($media->basename)
                                                ->text($ftitle),
                                        ]),
                                    (new Li())
                                        ->text($media->media_dtstr),
                                    (new Li())
                                        ->separator(' - ')
                                        ->items([
                                            (new Text(null, Files::size($media->size))),
                                            (new Link())
                                                ->href($media->file_url)
                                                ->text(__('open')),
                                        ]),
                                    (new Li())
                                        ->class('media-action')
                                        ->items([
                                            (new Link('featuredmedia-' . $media->media_id))
                                                ->class('featuredmedia-remove')
                                                ->href(App::backend()->url()->get('admin.post.media', [
                                                    'post_id'   => $post->post_id,
                                                    'media_id'  => $media->media_id,
                                                    'link_type' => 'featured',
                                                    'remove'    => '1',
                                                ]))
                                                ->items([
                                                    (new Img('images/trash.svg'))
                                                        ->alt(__('remove')),
                                                ]),
                                        ]),
                                ]),
                        ]);
                }
            }

            $sidebar['metas-box']['items']['featuredmedia'] = (new Set())
                ->items([
                    (new Text('h5', __('Featured media')))
                        ->class(['clear', 's-featuredmedia']),
                    ...$blocks,
                    empty($post_media) ?
                        (new Para())
                            ->class('s-featuredmedia')
                            ->items([
                                (new Link())
                                    ->class('button')
                                    ->href(App::backend()->url()->get('admin.media', ['post_id' => $post->post_id, 'link_type' => 'featured']))
                                    ->text(__('Add a featured media for this entry')),
                            ]) :
                        (new None()),
                ])
            ->render();
        }

        return '';
    }

    /**
     * @param      MetaRecord|null  $post   The post
     */
    public static function adminPostAfterForm(?MetaRecord $post): string
    {
        if ($post instanceof MetaRecord) {
            echo (new Form('featuredmedia-remove-hide'))
                ->action(App::backend()->url()->get('admin.post.media'))
                ->method('post')
                ->fields([
                    new Hidden(['post_id'], (string) $post->post_id),
                    new Hidden(['media_id'], ''),
                    new Hidden(['link_type'], 'featured'),
                    new Hidden(['remove'], '1'),
                    App::nonce()->formNonce(),
                ])
            ->render();
        }

        return '';
    }

    /**
     * @param      ArrayObject<int, mixed>  $filters  The filters
     */
    public static function adminPostFilter(ArrayObject $filters): string
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

        return '';
    }
}
