<?php

namespace PhpLab\Core\Enums\Http;

use PhpLab\Core\Domain\Base\BaseEnum;

class HttpHeaderEnum extends BaseEnum
{

    const LINK = 'Link';
    const TOTAL_COUNT = 'X-Pagination-Total-Count';
    const PAGE_COUNT = 'X-Pagination-Page-Count';
    const CURRENT_PAGE = 'X-Pagination-Current-Page';
    const PER_PAGE = 'X-Pagination-Per-Page';
    const TIME_ZONE = 'Time-Zone';
    const CONTENT_TYPE = 'Content-Type';
    const AUTHORIZATION = 'Authorization';
    const ACCESS_TOKEN = 'Access-Token';
    const CONTENT_DISPOSITION = 'Content-Disposition';
    const X_REQUESTED_WITH = 'X-Requested-With';
    const X_ENTITY_ID = 'X-Entity-Id';
    const LANGUAGE = 'Language';
    const X_RUNTIME = 'X-Runtime';
    const X_AGENT_FINGERPRINT = 'X-Agent-Fingerprint';

    const ACCESS_CONTROL_ALLOW_ORIGIN = 'Access-Control-Allow-Origin';
    const ACCESS_CONTROL_ALLOW_HEADERS = 'Access-Control-Allow-Headers';
    const ACCESS_CONTROL_ALLOW_METHODS = 'Access-Control-Allow-Methods';
    const ACCESS_CONTROL_EXPOSE_HEADERS = 'Access-Control-Expose-Headers';
    const ACCESS_CONTROL_ALLOW_CREDENTIALS = 'Access-Control-Allow-Credentials';
    const ACCESS_CONTROL_MAX_AGE = 'Access-Control-Max-Age';

}
