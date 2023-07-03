<?php

namespace PhpLab\Core\Enums\Http;

use PhpLab\Core\Domain\Base\BaseEnum;

class HttpMethodEnum extends BaseEnum
{

    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';
    const OPTIONS = 'OPTIONS';
    const HEAD = 'HEAD';
    const PATCH = 'PATCH';
    const TRACE = 'TRACE';
    const CONNECT = 'CONNECT';

}
