<?php

namespace PhpLab\Core\Tests\Unit;

use PhpLab\Core\Domain\Exceptions\UnprocessibleEntityException;
use PhpLab\Core\Domain\Helpers\EntityHelper;
use PhpLab\Core\Domain\Helpers\ValidationHelper;
use PhpLab\Core\Tests\Libs\AccessEntity;
use PhpLab\Test\Base\BaseTest;

final class EntityValidateTest extends BaseTest
{

    public function testSuccess()
    {
        $entity = new AccessEntity;
        $entity->setProjectId(1);
        $entity->setUserId(2);

        ValidationHelper::validateEntity($entity);
        $this->assertTrue(true);
    }

    public function testRequired()
    {
        $entity = new AccessEntity;

        //$this->expectException(UnprocessibleEntityException::class);

        $expected = [
            [
                'field' => 'userId',
                'message' => 'This value should not be blank.',
            ],
            [
                'field' => 'projectId',
                'message' => 'This value should not be blank.',
            ],
        ];
        try {
            ValidationHelper::validateEntity($entity);
        } catch (UnprocessibleEntityException $e) {
            $this->assertUnprocessibleEntityException($expected, $e);
        }
    }

    public function testInvalidType()
    {
        $entity = new AccessEntity;
        $entity->setProjectId('qwer');
        $entity->setUserId(2);

        $expected = [
            [
                "field" => "projectId",
                "message" => "This value should be positive.",
            ],
        ];
        try {
            ValidationHelper::validateEntity($entity);
        } catch (UnprocessibleEntityException $e) {
            $this->assertUnprocessibleEntityException($expected, $e);
        }
    }

    public function testInvalidRange()
    {
        $entity = new AccessEntity;
        $entity->setProjectId(-3);
        $entity->setUserId(2);

        $expected = [
            [
                'field' => 'projectId',
                'message' => 'This value should be positive.',
            ],
        ];
        try {
            ValidationHelper::validateEntity($entity);
        } catch (UnprocessibleEntityException $e) {
            $this->assertUnprocessibleEntityException($expected, $e);
        }
    }

}