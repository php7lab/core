<?php

namespace PhpLab\Core\Legacy\Code\helpers;

use php7rails\domain\BaseEntity;
use PhpLab\Core\Legacy\Yii\Helpers\FileHelper;
use php7rails\domain\helpers\Helper;
use PhpLab\Core\Legacy\Code\entities\ClassEntity;
use PhpLab\Core\Legacy\Code\entities\ClassUseEntity;
use PhpLab\Core\Legacy\Code\entities\CodeEntity;
use PhpLab\Core\Legacy\Code\entities\InterfaceEntity;
use PhpLab\Core\Legacy\Code\render\ClassRender;
use PhpLab\Core\Legacy\Code\render\InterfaceRender;
use PhpLab\Core\Legacy\Yii\Helpers\ArrayHelper;
use PhpLab\Dev\Package\Domain\Helpers\PackageHelper;

/**
 * Class ClassHelper
 *
 * @package PhpLab\Core\Legacy\Code\helpers
 */
class ClassHelper
{
	
	public static function classNameToFileName($class) {
		$alias = str_replace(['\\', '/'], SL, $class);
		return FileHelper::getAlias('@' . $alias);
	}

    public static function generateFile(string $alias, string $code) {
        $fileName = PackageHelper::pathByNamespace($alias);
	    FileHelper::save($fileName . '.php', $code);
    }

	public static function generate(BaseEntity $entity, $uses = []) {
		$codeEntity = new CodeEntity();
		$className = $entity->namespace . '\\' . $entity->name;
        $fileName = PackageHelper::pathByNamespace($className);
		/** @var ClassEntity|InterfaceEntity $entity */
		$codeEntity->fileName = $fileName;
		$codeEntity->namespace = $entity->namespace;
		$codeEntity->uses = Helper::forgeEntity($uses, ClassUseEntity::class);
		$codeEntity->code = self::render($entity);
		CodeHelper::save($codeEntity);
	}

    public static function render(BaseEntity $entity) {
		/** @var ClassRender|InterfaceRender $render */
		if($entity instanceof ClassEntity) {
			$render = new ClassRender();
		} elseif($entity instanceof InterfaceEntity) {
			$render = new InterfaceRender();
		}
		$render->entity = $entity;
		return $render->run();
	}
	
}
