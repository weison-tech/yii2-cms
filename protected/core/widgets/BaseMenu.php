<?php

namespace core\widgets;

use Yii;

/**
 * Base menu.
 * @author xiaomalover <xiaomalover@gmail.com>
 */
class BaseMenu extends \dmstr\widgets\Menu
{
    const EVENT_RUN = 'run';

    public function run()
    {
        //Do sort.
        $this->sortItems();
        //Trigger the run event
        $this->trigger(self::EVENT_RUN);
        parent::run();
    }

    /**
     * @param array $item the menu item
     */
    public function addItem($item)
    {
        if (!isset($item['label'])) {
            $item['label'] = 'Unnameds';
        }

        if (!isset($item['url'])) {
            $item['url'] = '#';
        }

        if (!isset($item['icon'])) {
            $item['icon'] = '';
        }

        if (!isset($item['sortOrder'])) {
            $item['sortOrder'] = 1000;
        }

        if (isset($item['isVisible']) && !$item['isVisible']) {
            return;
        }

        $valid = $this->checkPermission($item);
        if ($valid) {
            $this->items[] = $item;
        }
    }

    /**
     * Check permission
     * @param array $item
     * @return bool
     */
    private function checkPermission(&$item)
    {
        $url = isset($item['url']) ? $item['url'] : '#'; //If the menu is one level menu.
        if ($url != '#' && $url != '') {
            return $this->doCheck($url);
        } else {
            $hasSecond = $hasThird = false;
            foreach ($item['items'] as $key_second => $second) {
                //If the menu is second level menu.
                $second_url = (isset($second['url']) && isset($second['url'][0]) )? $second['url'][0] : '#';
                if ($second_url != '' && $second_url != '#') {
                    $hasPermission = $this->doCheck($second_url);
                    if ($hasPermission === false) {
                        unset($item['items'][$key_second]);
                    } else {
                        $hasSecond = true;
                    }
                } else { //If the menu is third level menu.
                    foreach ($second['items'] as $key_third => $third) {
                        $third_url = (isset($third['url']) && isset($third['url'][0]) )? $third['url'][0] : '#';
                        if ($third_url != '' && $third_url != '#') {
                            $hasPermission = $this->doCheck($third_url);
                            if ($hasPermission === false) {
                                unset($item['items'][$key_second]['items'][$key_third]);
                            } else {
                                $hasThird = true;
                            }
                        }
                    }
                    if ($hasThird === false) {
                        unset($item['items'][$key_second]);
                    }
                }
            }
            return $hasSecond || $hasThird;
        }
    }

    /**
     * Check whether can access the given url.
     * @param string $url
     * @return boolean bool
     */
    private function doCheck($url)
    {
        $hasPermission = false;

        if (Yii::$app->admin->can($url)) {
            $hasPermission = true;
        } else {
            //Check if has wildcard (eg. /admin/*)
            $temp = explode("/", $url);
            $temp = array_filter($temp);
            foreach ($temp as $k => $v) {
                $match = '';
                $i = $k;
                do {
                    $match =  '/' . $temp[$i] . $match;
                    $i--;
                } while($i > 0);

                if (Yii::$app->admin->can($match . '/*')) {
                    $hasPermission = true;
                    break;
                }
            }

            //Check whether the action is not need permission check.
            if ($hasPermission === false) {
                $url = ltrim($url, "/");
                foreach (Yii::$app->params['notCheckPermissionAction'] as $route) {
                    if (substr($route, -1) === '*') {
                        $route = rtrim($route, '*');
                        if ($route === '' || strpos($url, $route) === 0) {
                            $hasPermission = true;
                            break;
                        }
                    } else {
                        if ($url === $route) {
                            $hasPermission = true;
                            break;
                        }
                    }
                }
            }
        }

        if ($hasPermission === false) {
            $hasPermission = Yii::$app->admin->can('/' . $url . '/index');
        }

        return $hasPermission;
    }

    /**
     * Sorts the item attribute by sortOrder
     */
    private function sortItems()
    {
        usort($this->items, function ($a, $b) {
            if ($a['sortOrder'] == $b['sortOrder']) {
                return 0;
            } else {
                if ($a['sortOrder'] < $b['sortOrder']) {
                    return -1;
                } else {
                    return 1;
                }
            }
        });
    }
}
