<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 14.08.2018
 * Time: 15:20
 */

namespace app\components;

use yii\base\BootstrapInterface;

class LanguageSelector implements BootstrapInterface
{
    public $supportedLanguages = ['en', 'ru'];

    public function bootstrap($app)
    {
        $cookieLanguage = $app->request->cookies['language'];
        if(isset($cookieLanguage) && in_array($cookieLanguage, $this->supportedLanguages)) {
            $app->language = $app->request->cookies['language'];
        }
    }
}