<?php

namespace PhpLab\Core\Libs\I18Next\Facades;

use PhpLab\Core\Libs\I18Next\Interfaces\Services\TranslationServiceInterface;
use Yii;

class I18Next {

    public static function t(string $bundleName, string $key, array $variables = []) {
        /** @var TranslationServiceInterface $translationService */
        $translationService = Yii::$container->get(TranslationServiceInterface::class);
        return $translationService->t($bundleName, $key, $variables);
    }

    public static function addBundle(string $bundleName, string $path) {
        /** @var TranslationServiceInterface $translationService */
        $translationService = Yii::$container->get(TranslationServiceInterface::class);
        $translationService->addBundle($bundleName, $path);
    }

}
