<?php
/**
 * @copyright Copyright (c) 2017 Kaicai Media LLC
 * @author xiaomalover <xiaomalover@gmail.com>
 */

namespace core\modules\admin\widgets;

use yii\grid\ActionColumn as BaseColumn;
use yii\helpers\Html;
use Yii;

class ActionColumn extends  BaseColumn
{
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', 'View');
                        $btnClass = 'info';
                        break;
                    case 'update':
                        $title = Yii::t('yii', 'Update');
                        $btnClass = 'primary';
                        break;
                    case 'delete':
                        $title = Yii::t('yii', 'Delete');
                        $btnClass = 'danger';
                        break;
                    default:
                        $btnClass = 'default';
                        $title = ucfirst($name);
                }
                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                    'class' => "btn btn-sm btn-$btnClass btn-flat"
                ], $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                return Html::a($icon . ' ' . $title , $url, $options);
            };
        }
    }
}
