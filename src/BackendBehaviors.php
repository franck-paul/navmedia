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
use Dotclear\Helper\File\File;
use Dotclear\Helper\File\Files;

/**
 * @todo switch Helper/Html/Form/...
 */
class BackendBehaviors
{
    /**
     * adminMediaItemForm behavior
     *
     * @param      File  $file   The file
     */
    public static function adminMediaItemForm(File $file): string
    {
        // Récupération des infos nécessaires à la construction des liens de navigation

        // identificateur du billet en cours d'édition
        $post_id = empty($_GET['post_id']) ? null : (int) $_GET['post_id'];

        // Indicateur d'affichage popup de la page détail du média
        $popup = (int) !empty($_GET['popup']);

        // Paramètres supplémentaires pour les URLs
        $opts = [
            'popup'   => $popup,
            'post_id' => $post_id,
        ];

        if (dirname($file->relname) !== '') {
            // Construction de l'objet de parcours du répertoire dans lequel se trouve le média courant
            $mp_media = App::media();
            // Changement du répertoire courant
            $mp_media->chdir(dirname($file->relname));
            // Récupération du contenu du répertoire
            $mp_media->getDir();
            // Récupération de la liste des fichiers uniquement (les sous-répertoires sont exclus)
            $mp_items = array_merge($mp_media->getFiles());
            if (count($mp_items) > 1) {
                // On a plus d'un fichier dans le répertoire
                // Reprise de la présentation utilisée dans la gestion des médias.

                echo '<div class="media-list"><div class="files-group"><div class="media-items-bloc">';
                $counter = count($mp_items);

                for ($mp_i = 0; $mp_i < $counter; ++$mp_i) {
                    if ($mp_items[$mp_i]->media_id == $file->media_id) {
                        // On a trouvé le média courant dans la liste

                        // Média précédent
                        echo '<div class="media-item media-col-0"><h4>' . __('Previous media:') . '</h4>' .
                            ($mp_i > 0 ? self::displayMediaItem($mp_items[$mp_i - 1], $opts) : __('(none)')) .
                            '</div>';

                        // Image suivante
                        echo '<div class="media-item media-col-1"><h4>' . __('Next media:') . '</h4>' .
                            ($mp_i < count($mp_items) - 1 ? self::displayMediaItem($mp_items[$mp_i + 1], $opts) : __('(none)')) .
                            '</div>';

                        break;
                    }
                }

                echo '</div></div></div>';
            }
        }

        return '';
    }

    /**
     * Display media attributes and links
     *
     * @param      File                     $file   The file
     * @param      array<string, mixed>     $opts   The options
     */
    private static function displayMediaItem(File $file, array $opts): string
    {
        // Construction de l'URL pour le lien de navigation
        $mp_link = App::backend()->url()->get('admin.media.item', [
            'id' => $file->media_id,
            ...$opts,
        ]);

        return // Vignette du média avec lien de navigation
        '<p><a class="media-icon media-link" href="' . $mp_link . '">' .
        '<img class="media-icon-preview" style="margin-right: 0.5em; margin: 2px;" src="' . $file->media_icon . '" alt=""></a></p>' .

        // Attributs
        '<ul style="padding-bottom: 1em;">' .

        // Nom du fichier avec lien de navigation
        '<li style="list-style: none outside none;"><a class="media-link" href="' . $mp_link . '">' . $file->basename . '</a></li>' .

        // Titre du média
        '<li style="list-style: none outside none;">' . $file->media_title . '</li>' .

        // Date et taille du média et URL d'ouverture
        '<li style="list-style: none outside none;">' . $file->media_dtstr . ' - ' .
        Files::size($file->size) . ' - ' . '<a href="' . $file->file_url . '">' . __('open') . '</a>' .
        '</li>' .

        '</ul>';
    }
}
