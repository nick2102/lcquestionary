<?php
/**
 * LcTrainee_Mapper
 *
 * Main plugin class for registering/unregistering plugin functionality
 *
 * @version 1.0
 * @author Nikola Nikoloski
 */

class LcTrainee_Mapper
{

    private static $instance = null;

    /**
     * Returns a single instance of this class.
     */
    public static function getInstance ()
    {

        if ( null == self::$instance ) {
            self::$instance = new LcTrainee_Mapper();
        }

        return self::$instance;
    }

    /**
     * class constructor
     */
    public function __construct ()
    {
    }

    public static function lctrainee_city_coordinates($slug)
    {
        $coordinates = [
            'skopje' => ['lat' => '41.99646', 'lng' => '21.43141'],
            'berovo' => ['lat' => '41.70306', 'lng' => '22.85778'],
            'bitola' => ['lat' => '41.03143', 'lng' => '21.33474'],
            'bogdanci' => ['lat' => '41.20306', 'lng' => '22.57556'],
            'valandovo' => ['lat' => '41.31744', 'lng' => '22.56002'],
            'veles' => ['lat' => '41.71556', 'lng' => '21.77556'],
            'vinica' => ['lat' => '41.88278', 'lng' => '22.50917'],
            'gevgelija' => ['lat' => '41.14166', 'lng' => '22.50141'],
            'gostivar' => ['lat' => '41.79601', 'lng' => '20.90819'],
            'debar' => ['lat' => '41.52444', 'lng' => '20.52421'],
            'delcevo' => ['lat' => '41.96722', 'lng' => '22.76944'],
            'demir-kapija' => ['lat' => '41.392331764', 'lng' => '22.223832438'],
            'demir-hisar' => ['lat' => '41.28083', 'lng' => '21.14389'],
            'kavadarci' => ['lat' => '41.43306', 'lng' => '22.01194'],
            'kicevo' => ['lat' => '41.51267', 'lng' => '20.95886'],
            'kocani' => ['lat' => '41.91639', 'lng' => '22.41278'],
            'kratovo' => ['lat' => '42.07838', 'lng' => '22.1807'],
            'kriva-palanka' => ['lat' => '42.25', 'lng' => '22.33333'],
            'krusevo' => ['lat' => '41.14', 'lng' => '21.26'],
            'kumanovo' => ['lat' => '42.13222', 'lng' => '21.71444'],
            'makedonska-kamenica' => ['lat' => '42.02079', 'lng' => '22.5876'],
            'makedonski-brod' => ['lat' => '41.51361', 'lng' => '21.21528'],
            'negotino' => ['lat' => '41.48456', 'lng' => '22.09056'],
            'ohrid' => ['lat' => '41.11722', 'lng' => '20.80194'],
            'pehcevo' => ['lat' => '41.76', 'lng' => '22.88'],
            'prilep' => ['lat' => '41.34514', 'lng' => '21.55504'],
            'probistip' => ['lat' => '42.01', 'lng' => '22.15'],
            'radovis' => ['lat' => '41.65', 'lng' => '22.5'],
            'resen' => ['lat' => '41.08889', 'lng' => '21.01222'],
            'sveti-nikole' => ['lat' => '41.86956', 'lng' => '21.95274'],
            'struga' => ['lat' => '41.17799', 'lng' => '20.67784'],
            'strumica' => ['lat' => '41.4375', 'lng' => '22.64333'],
            'tetovo' => ['lat' => '42.04444', 'lng' => '20.9025'],
            'stip' => ['lat' => '41.74583', 'lng' => '22.19583'],
            'dojran' => ['lat' => '41.18647', 'lng' => '22.7203'],
        ];

        return $coordinates[$slug];
    }

    public static function lctrainee_energy_marks($mark)
    {
        $marks = [
        'a_plus' => 'A+',
        'a' => 'A',
        'b' => 'B',
        'c' => 'C',
        'd' => 'D',
        'e' => 'E',
        'f' => 'F',
        ];

        return $marks[$mark];
    }

    public static function lctrainee_energy_marks_by_level($level)
    {
        $marks = [
            'level_6' => 'A+',
            'level_5' => 'A',
            'level_4' => 'B',
            'level_3' => 'C',
            'level_2' => 'D',
            'level_1' => 'E',
        ];

        return $marks[$level];
    }

    public static function lctrainee_residence($id)
    {
        $value = [
            '1' => __('House', 'trainee'),
            '2' => __('Apartment', 'trainee'),
        ];

        return $value[$id];
    }

    public static function lctrainee_map_city($slug)
    {
        return get_term_by('slug', $slug, 'lctrainee_building_city');
    }

    public static function points_by_mark($result) {
        $points = 100;
        switch ($result) {
            case 'a_plus':
                $points = 100;
                break;
            case 'a':
                $points = 86;
                break;
            case 'b':
                $points = 71;
                break;
            case 'c':
                $points = 55;
                break;
            case 'd':
                $points = 39;
                break;
            case 'e':
                $points = 22;
                break;
        }

        return $points;
    }
}