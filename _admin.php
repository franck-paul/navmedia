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

if (!defined('DC_CONTEXT_ADMIN')) {return;}

// dead but useful code, in order to have translations
__('Media Navigator') . __('Navigate between media in folder');

$core->addBehavior('adminMediaItemForm', ['adminNavMedia', 'adminMediaItemForm']);

class adminNavMedia
{
    /**
    adminMediaItemForm behavior

    @param    file    <b>fileItem</b>    File item
     */
    public static function adminMediaItemForm($file)
    {
        global $core;

        // Récupération des infos nécessaires à la construction des liens de navigation

        // identificateur du billet en cours d'édition
        $post_id = !empty($_GET['post_id']) ? (integer) $_GET['post_id'] : null;

        // Indicateur d'affichage popup de la page détail du média
        $popup = (integer) !empty($_GET['popup']);

        // Paramètres supplémentaires pour les URLs
        $opt = '&amp;popup=' . $popup . '&amp;post_id=' . $post_id;

        // Identificateur du média
        $id = !empty($_REQUEST['id']) ? (integer) $_REQUEST['id'] : '';

        if (dirname($file->relname) != "") {

            // Construction de l'objet de parcours du répertoire dans lequel se trouve le média courant
            $mp_media = new dcMedia($core);
            // Changement du répertoire courant
            $mp_media->chdir(dirname($file->relname));
            // Récupération du contenu du répertoire
            $mp_media->getDir();
            $mp_dir = &$mp_media->dir;

            // Récupération de la liste des fichiers uniquement (les sous-répertoires sont exclus)
            $mp_items = array_values(array_merge($mp_dir['files']));
            if (count($mp_items) > 1) {

                // On a plus d'un fichier dans le répertoire
                // Reprise de la présentation utilisée dans la gestion des médias.

//                echo '<h3>'.__('Navigation').'</h3>';
                echo '<div class="media-list"><div class="files-group">';

                for ($mp_i = 0; $mp_i < count($mp_items); $mp_i++) {
                    if ($mp_items[$mp_i]->media_id == $file->media_id) {
                        // On a trouvé le média courant dans la liste

                        // Média précédent
                        echo '<div class="media-item media-col-0">' . '<h4>' . __('Previous media:') . '</h4>' .
                            ($mp_i > 0 ? self::displayMediaItem($mp_items[$mp_i - 1], $opt) : __('(none)')) .
                            '</div>';

                        // Image suivante
                        echo '<div class="media-item media-col-1">' . '<h4>' . __('Next media:') . '</h4>' .
                            ($mp_i < count($mp_items) - 1 ? self::displayMediaItem($mp_items[$mp_i + 1], $opt) : __('(none)')) .
                            '</div>';

                        break;
                    }
                }
                echo '</div></div>';
            }
        }
    }

    /**
    Display media attributes and links

    @param    file    <b>fileItem</b>    File item
    @param    opt    <b>string</b>    additional parameter for URL
     */
    private static function displayMediaItem($file, $opt)
    {
        // Construction de l'URL pour le lien de navigation
        $mp_link = 'media_item.php?id=' . $file->media_id . $opt;

        $ret =

        // Vignette du média avec lien de navigation
        '<p><a class="media-icon media-link" href="' . $mp_link . '">' .
        '<img style="margin-right: 0.5em; padding: 2px;" src="' . $file->media_icon . '" alt="" /></a></p>' .

        // Attributs
        '<ul style="padding-bottom: 1em;">' .

        // Nom du fichier avec lien de navigation
        '<li style="list-style: none outside none;"><a class="media-link" href="' . $mp_link . '">' . $file->basename . '</a></li>' .

        // Titre du média
        '<li style="list-style: none outside none;">' . $file->media_title . '</li>' .

        // Date et taille du média et URL d'ouverture
        '<li style="list-style: none outside none;">' . $file->media_dtstr . ' - ' .
        files::size($file->size) . ' - ' . '<a href="' . $file->file_url . '">' . __('open') . '</a>' .
            '</li>' .

            '</ul>';

        return $ret;
    }
}
