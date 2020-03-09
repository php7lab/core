<?php

namespace PhpLab\Core\Enums;

use PhpLab\Core\Domain\Base\BaseEnum;

class StatusEnum extends BaseEnum
{

    // удален
    const DELETED = -10;

    // отключен
    const DISABLE = 0;

    // отвергнут / отклонен
    const REJECTED = 10;

    // заблокирован
    const BLOCKED = 20;

    // ожидает одобрения / премодерация
    const WAIT_APPROVING = 90;

    // включен / одобрен
    const ENABLE = 100;

    // обработано / завершено
    const COMPLETED = 200;

}
