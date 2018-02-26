<?php
namespace core\modules\file;

/**
 * Class Module
 * @package core\modules\file
 * @author xiaomalover <xiaomalover@gmail.com>
 */
class Module extends \core\components\Module
{
    /**
     * @var bool whether this module is core module.
     */
    public $isCoreModule = true;

    /**
     * @var array mime types to show inline instead of download
     */
    public $inlineMimeTypes = [
        'application/pdf',
        'application/x-pdf',
        'image/gif',
        'image/png',
        'image/jpeg'
    ];
}
