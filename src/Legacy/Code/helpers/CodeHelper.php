<?php

namespace PhpLab\Core\Legacy\Code\helpers;

use PhpLab\Core\Legacy\Code\entities\CodeEntity;
use PhpLab\Core\Legacy\Code\render\CodeRender;
use PhpLab\Core\Legacy\Yii\Helpers\FileHelper;
use php7extension\core\store\Store;

class CodeHelper
{
	
	public static function generatePhpData($alias, $data) {
		$codeEntity = new CodeEntity();
		$codeEntity->fileName = $alias;
		$codeEntity->code = self::encodeDataForPhp($data);
		self::save($codeEntity);
	}
	
	public static function save(CodeEntity $codeEntity) {
		$pathName = $codeEntity->fileName;
		$fileName = $pathName . '.' . $codeEntity->fileExtension;
		$code = CodeHelper::render($codeEntity);
		FileHelper::save($fileName, $code);
	}
	
	private static function render(CodeEntity $codeEntity) {
		$render = new CodeRender();
		$render->entity = $codeEntity;
		return $render->run();
	}
	
	private static function encodeDataForPhp($data) {
		$store = new Store('php');
		$content = $store->encode($data);
		$code = 'return ' . $content . ';';
		return $code;
	}
}
