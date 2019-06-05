<?php
namespace core\modules\admin\forms;

use core\libs\DynamicConfig;
use core\libs\ThemeHelper;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class SettingForm extends Model
{
    /**
     * @var string $timeZone
     */
    public $timeZone;

    /**
     * @var string $themes
     */
    public $theme;

    /**
     * @var string $name
     */
    public $name;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $settingsManager = Yii::$app->settings;

        $this->theme = Yii::$app->view->theme->name;
        $this->name = $settingsManager->get('name');
        $this->timeZone = $settingsManager->get('timeZone');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['timeZone', 'theme', 'name'], 'required'],
            ['timeZone', 'in', 'range' => \DateTimeZone::listIdentifiers()],
        ];
    }

    /**
     * @return array a list of available themes
     */
    public function getThemes() {
        $themes = [];

        foreach (ThemeHelper::getThemes() as $theme) {
            $themes[$theme->name] = $theme->name;
        }

        return $themes;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('AdminModule.base', 'Application Name'),
            'theme' => Yii::t('AdminModule.base', 'Theme'),
            'timeZone' => Yii::t('AdminModule.base', 'Time Zone'),
        ];
    }

    /**
     * Saves the form
     *
     * @return boolean
     */
    public function save()
    {
        $settingsManager = Yii::$app->settings;

        $settingsManager->set('timeZone', $this->timeZone);
        $settingsManager->set('name', $this->name);
        $settingsManager->set('theme', $this->theme);

        DynamicConfig::rewrite();

        return true;
    }
}
