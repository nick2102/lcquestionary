<?php
/**
 * LcTrainee_Render_View
 *
 * Render partial and whole View
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class LcTrainee_Render_View
{
    public static function view($template, $d = [])
    {
        $path = TRAINEE_PLUGIN_DIR . '/views/shortcodes/'. $template . '.php';
        $data = $d;

        ob_start();
        include $path;

        return ob_get_clean();
    }
}