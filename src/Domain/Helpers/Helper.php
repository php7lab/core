<?php

namespace PhpLab\Core\Domain\Helpers;

use PhpLab\Core\Legacy\Yii\Base\Model;
use PhpLab\Core\Legacy\Yii\Helpers\ArrayHelper;
use PhpLab\Core\Domain\Exceptions\UnprocessableEntityHttpException;
use PhpLab\Core\Helpers\ClassHelper;

class Helper
{

    public static function idsToArray($param)
    {
        if (empty($param)) {
            return [];
        }
        if ( ! is_array($param)) {
            $param = explode(',', $param);
        }
        $param = array_map('trim', $param);
        //$param = array_map('intval', $param);
        //$param = array_map(function(){}, $param);
        return $param;
    }

    public static function forgeEntity($value, string $className, bool $isCollection = null, $isSaveKey = false)
    {
        if (empty($value)) {
            return null;
        }
        if ($value instanceof $className) {
            return $value;
        }
        if ( ! is_array($value)) {
            return null;
        }
        if (ArrayHelper::isIndexed($value) || $isCollection) {
            $result = [];
            foreach ($value as $key => &$item) {
                if ($isSaveKey) {
                    $result[$key] = self::forgeEntity($item, $className);
                } else {
                    $result[] = self::forgeEntity($item, $className);
                }
            }
        } else {
            $result = new $className();
            EntityHelper::setAttributes($result, $value);
            //$result->load($value);
        }
        /*if($isCollection !== null) {
            if() {

            }
        }*/
        return $result;
    }

    public static function post($data = null, Model $model = null)
    {
        if (empty($data) && is_object($model)) {
            $data = \Yii::$app->request->post($model->formName());
        }
        if (empty($data)) {
            $data = \Yii::$app->request->post();
        }
        return $data;
    }

    public static function forgeForm(Model $model, $data = null)
    {
        $data = self::post($data, $model);
        $model->setAttributes($data, false);
        /*if(!$model->validate()) {
            throw new UnprocessableEntityHttpException($model);
        }*/
    }

    public static function createForm($form, $data = null, $scenario = null): Model
    {
        if (is_string($form) || is_array($form)) {
            $form = ClassHelper::createObject($form);
        }
        /** @var Model $form */
        if ( ! empty($data)) {
            ClassHelper::configure($form, $data);
        }
        if ( ! empty($scenario)) {
            $form->scenario = $scenario;
        }
        return $form;
    }

    public static function validateForm($form, $data = null, $scenario = null)
    {
        $form = self::createForm($form, $data, $scenario);
        if ( ! $form->validate()) {
            throw new UnprocessableEntityHttpException($form);
        }
        return $form->getAttributes();
    }


    public static function toArray($value, $recursive = true)
    {
        if (is_object($value) && method_exists($value, 'toArray')) {
            return $value->toArray([], [], $recursive);
        }
        if ( ! ArrayHelper::isIndexed($value)) {
            return $value;
        }
        foreach ($value as &$item) {
            $item = self::toArray($item, $recursive);
        }
        return $value;
    }

}