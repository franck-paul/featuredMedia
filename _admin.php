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

if (!defined('DC_CONTEXT_ADMIN')) {return;}

$core->addBehavior('adminPostFormItems', ['featuredMediaAdmin', 'adminPostFormItems']);
$core->addBehavior('adminPostAfterForm', ['featuredMediaAdmin', 'adminPostAfterForm']);
$core->addBehavior('adminPostHeaders', ['featuredMediaAdmin', 'postHeaders']);

$core->addBehavior('adminPageFormItems', ['featuredMediaAdmin', 'adminPostFormItems']);
$core->addBehavior('adminPageAfterForm', ['featuredMediaAdmin', 'adminPostAfterForm']);
$core->addBehavior('adminPageHeaders', ['featuredMediaAdmin', 'postHeaders']);

class featuredMediaAdmin
{
    public static function postHeaders()
    {
        $core = &$GLOBALS['core'];
        return
        '<script type="text/javascript">' . "\n" .
        dcPage::jsVar('dotclear.msg.confirm_remove_featuredmedia',
            __('Are you sure you want to remove featured media "%s"?')) .
        "</script>\n" .
        dcPage::jsLoad(dcPage::getPF('featuredMedia/js/post.js'));
    }

    public static function adminPostFormItems($main, $sidebar, $post)
    {
        if ($post !== null) {
            $core       = &$GLOBALS['core'];
            $post_media = $core->media->getPostMedia($post->post_id, null, 'featured');
            $nb_media   = count($post_media);
            $title      = __('Featured media');
            $item       = '<h5 class="clear s-featuredmedia">' . $title . '</h5>';
            foreach ($post_media as $f) {
                $ftitle = $f->media_title;
                if (strlen($ftitle) > 18) {
                    $ftitle = substr($ftitle, 0, 16) . '...';
                }
                $item .=
                '<div class="media-item s-featuredmedia">' .
                '<a class="media-icon" href="' . $core->adminurl->get('admin.media.item', ['id' => $f->media_id]) . '">' .
                '<img src="' . $f->media_icon . '" alt="" title="' . $f->basename . '" /></a>' .
                '<ul>' .
                '<li><a class="media-link" href="' . $core->adminurl->get('admin.media.item', ['id' => $f->media_id]) . '" ' .
                'title="' . $f->basename . '">' . $ftitle . '</a></li>' .
                '<li>' . $f->media_dtstr . '</li>' .
                '<li>' . files::size($f->size) . ' - ' .
                '<a href="' . $f->file_url . '">' . __('open') . '</a>' . '</li>' .

                '<li class="media-action"><a class="featuredmedia-remove" id="featuredmedia-' . $f->media_id . '" ' .
                'href="' . $core->adminurl->get('admin.post.media', [
                    'post_id'   => $post->post_id,
                    'media_id'  => $f->media_id,
                    'link_type' => 'featured',
                    'remove'    => '1'
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
                $item .=
                '<p class="s-featuredmedia"><a class="button" href="' . $core->adminurl->get('admin.media', ['post_id' => $post->post_id, 'link_type' => 'featured']) . '">' .
                __('Add a featured media for this entry') . '</a></p>';
            }
            $sidebar['metas-box']['items']['featuredmedia'] = $item;
        }
    }

    public static function adminPostAfterForm($post)
    {
        if ($post !== null) {
            $core = &$GLOBALS['core'];
            echo
            '<form action="' . $core->adminurl->get('admin.post.media') . '" id="featuredmedia-remove-hide" method="post">' .
            '<div>' . form::hidden(['post_id'], $post->post_id) .
            form::hidden(['media_id'], '') .
            form::hidden(['link_type'], 'featured') .
            form::hidden(['remove'], 1) .
            $core->formNonce() . '</div></form>';
        }
    }
}
