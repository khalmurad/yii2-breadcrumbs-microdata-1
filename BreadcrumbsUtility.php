<?php

namespace mp\bmicrodata;

use yii\helpers\Url;
use yii\helpers\Html;

/**
 * Class BreadcrumbsUtility
 * @package mp\bmicrodata
 */
class BreadcrumbsUtility
{
    /**
     * Returns an array of breadcrumbs microdata
     *
     * @param array $links list breadcrumbs links (yii\widgets\Breadcrumbs Public property links)
     * @param int $home start breadcrumbs links (if isset home, $home=2. If not isset home, $home=1)
     * @return array breadcrumbs links
     */
    public static function UseMicroData($links, $home = 2)
    {
        if (empty($links)) {
            return [];
        }

        foreach ($links as $key => &$link) {
            if(is_array($link)) {
                $link['template'] = self::getTemplate($link['label'], $link['url'], $key+$home);
            }
        }

        return $links;
    }

    /**
     * Returns a template with microdata for the home page
     *
     * @param string $label string name home label
     * @param array|string $url string url link home page
     * @return array
     */
    public static function getHome($label, $url)
    {
        $home = [
            'label'     => $label,
            'url'       => $url,
            'template'  => self::getTemplate($label, $url, 1)
        ];

        return $home;
    }

    /**
     * It used only within the class, and contains markup template schema.org/BreadcrumbList
     *
     * @param string $label
     * @param array|string $url
     * @param int $key
     * @return string template microdata
     */
    private static function getTemplate($label, $url, $key)
    {
        return '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">'
                . Html::a('<span itemprop="name">'.$label.'</span>', Url::to($url), ['itemprop'=>'item'])
                . '<meta itemprop="position" content="'.$key.'" /></li>';
    }
}
