<?php

namespace PhpLab\Core\Libs\I18Next\Services;

use PhpLab\Core\Legacy\Yii\Helpers\FileHelper;
use PhpLab\Core\Libs\Store\StoreFile;
use PhpLab\Core\Libs\I18Next\Interfaces\Services\TranslationServiceInterface;
use PhpLab\Core\Libs\I18Next\Libs\Translator;

class TranslationService implements TranslationServiceInterface
{

    /** @var Translator[] $translators */
    private $translators = [];
    private $bundles = [];
    private $language;
    private $defaultLanguage;
    private $fallbackLanguage;

    public function __construct(array $bundles = [], string $defaultLanguage = null)
    {
        if($bundles) {
            $this->bundles = $bundles;
        } else {
            $store = new StoreFile($_ENV['I18NEXT_CONFIG_FILE']);
            $config = $store->load();
            $defaultLanguage = $defaultLanguage ?? ($config['defaultLanguage'] ?? 'en');
            $this->bundles = $config['bundles'] ?? [];
        }
        $this->defaultLanguage = substr($defaultLanguage, 0, 2);
        $this->language = $this->defaultLanguage;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language, string $fallback = null)
    {
        $language = explode('-', $language)[0];
        $this->language = $language;
        foreach ($this->translators as $translator) {
            $translator->setLanguage($language, $fallback);
        }
        if ($fallback) {
            $this->fallbackLanguage = $fallback;
        }
    }

    public function t(string $bundleName, string $key, array $variables = [])
    {
        $translator = $this->getTranslator($bundleName);
        return $translator->getTranslation($key, $variables);
    }

    public function addBundle(string $bundleName, string $bundlePath)
    {
        $path = $this->forgePath($bundlePath);
        $i18n = new Translator($path, $this->language);
        $this->translators[$bundleName] = $i18n;
    }

    private function getTranslator(string $bundleName): Translator
    {
        if ( ! isset($this->translators[$bundleName])) {
            $bundlePath = $this->bundles[$bundleName];
            $this->addBundle($bundleName, $bundlePath);
        }
        return $this->translators[$bundleName];
    }

    private function forgePath(string $bundlePath): string
    {
        $rootDir = FileHelper::rootPath();
        $fileMask = "$rootDir/$bundlePath";
        return $fileMask;
    }

}
