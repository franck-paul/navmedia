<?php

/**
 * @brief navmedia, a plugin for Dotclear 2
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

namespace Dotclear\Plugin\navmedia;

use Dotclear\App;
use Dotclear\Core\Backend\MediaPage;
use Dotclear\Core\MediaFile;
use Dotclear\Helper\File\Files;
use Dotclear\Helper\Html\Form\Div;
use Dotclear\Helper\Html\Form\Img;
use Dotclear\Helper\Html\Form\Li;
use Dotclear\Helper\Html\Form\Link;
use Dotclear\Helper\Html\Form\Para;
use Dotclear\Helper\Html\Form\Set;
use Dotclear\Helper\Html\Form\Text;
use Dotclear\Helper\Html\Form\Ul;

class BackendBehaviors
{
    /**
     * adminMediaItemForm behavior
     *
     * @param      MediaFile  $file   The file
     */
    public static function adminMediaItemForm(MediaFile $file): string
    {
        if (dirname($file->relname) !== '') {
            $page = new MediaPage();

            // Récupération de la liste des fichiers uniquement (les sous-répertoires sont exclus)
            $mp_items = array_merge(App::media()->getFiles());
            if (count($mp_items) > 1) {
                // On a plus d'un fichier dans le répertoire
                // Reprise de la présentation utilisée dans la gestion des médias.

                $counter = count($mp_items);
                $blocks  = [];
                for ($mp_i = 0; $mp_i < $counter; ++$mp_i) {
                    if ($mp_items[$mp_i]->media_id == $file->media_id) {
                        // On a trouvé le média courant dans la liste

                        // Média précédent
                        $blocks[] = (new Div())
                            ->class(['media-item-bloc', 'media-item', 'media-col-0'])
                            ->items([
                                (new Text('h4', __('Previous media:'))),
                                $mp_i > 0 ?
                                    self::displayMediaItem($mp_items[$mp_i - 1], $page->values()) :
                                    (new Text(null, __('(none)'))),
                            ]);

                        // Image suivante
                        $blocks[] = (new Div())
                            ->class(['media-item-bloc', 'media-item', 'media-col-1'])
                            ->items([
                                (new Text('h4', __('Next media:'))),
                                $mp_i < count($mp_items) - 1 ?
                                    self::displayMediaItem($mp_items[$mp_i + 1], $page->values()) :
                                    (new Text(null, __('(none)'))),
                            ]);

                        break;
                    }
                }

                echo
                (new Div())
                    ->class('media-list')
                    ->items([
                        (new Div())
                            ->class('files-group')
                            ->items([
                                (new Div())
                                    ->class('media-items-bloc')
                                    ->items($blocks),
                            ]),
                    ])
                ->render();
            }
        }

        return '';
    }

    /**
     * Display media attributes and links
     *
     * @param      MediaFile                $file   The file
     * @param      array<string, mixed>     $opts   The options
     */
    private static function displayMediaItem(MediaFile $file, array $opts): Set
    {
        // Construction de l'URL pour le lien de navigation
        $mp_link = App::backend()->url()->get('admin.media.item', [
            'id' => $file->media_id,
            ...$opts,
        ]);

        return (new Set())
            ->items([
                // Vignette du média avec lien de navigation
                (new Para())
                    ->items([
                        (new Link())
                            ->class(['media-icon', 'media-link'])
                            ->href($mp_link)
                            ->items([
                                (new Img($file->media_icon))
                                    ->class('media-icon-square'),
                                (new Text(null, $file->basename)),
                            ]),
                    ]),
                (new Ul())
                    ->items([
                        (new Li())
                            ->text($file->media_title),
                        (new Li())
                            ->separator(' - ')
                            ->items([
                                (new Text(null, $file->media_dtstr)),
                                (new Text(null, Files::size($file->size))),
                                (new Link())
                                    ->class('modal-image')
                                    ->href($file->file_url)
                                    ->text(__('open')),
                            ]),
                    ]),
            ]);
    }
}
