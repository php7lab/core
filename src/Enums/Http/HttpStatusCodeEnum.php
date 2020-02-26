<?php

namespace PhpLab\Core\Enums\Http;

use PhpLab\Core\Domain\Base\BaseEnum;

class HttpStatusCodeEnum extends BaseEnum
{

    // 1xx: Informational (информационные)

    const CONTINUE = 100; // продолжай
    const SWITCHING_PROTOCOLS = 101; // переключение протоколов
    const PROCESSING = 102; // идёт обработка

    // 2xx: Success (успешно)

    const OK = 200; // хорошо
    const CREATED = 201; // создано
    const ACCEPTED = 202; // принято
    const NON_AUTHORITATIVE_INFORMATION = 203; // информация не авторитетна
    const NO_CONTENT = 204; // нет содержимого
    const RESET_CONTENT = 205; // сбросить содержимое
    const PARTIAL_CONTENT = 206; // частичное содержимое
    const MULTI_STATUS = 207; // многостатусный
    const ALREADY_REPORTED = 208; // уже сообщалось
    const IM_USED = 226; // использовано IM

    // 3xx: Redirection (перенаправление)

    const MULTIPLE_CHOICES = 300; // множество выборов
    const MOVED_PERMANENTLY = 301; // перемещено навсегда
    const MOVED_TEMPORARILY = 302; //перемещено временн
    const FOUND = 302; //найдено
    const SEE_OTHER = 303; //смотреть другое
    const NOT_MODIFIED = 304; //не изменялось
    const USE_PROXY = 305; //использовать прокси
    const reserved = 306; //зарезервировано (код использовался только в ранних спецификациях)
    const TEMPORARY_REDIRECT = 307; //временное перенаправление
    const PERMANENT_REDIRECT = 308; //постоянное перенаправление

    // 4xx: Client Error (ошибка клиента)

    const BAD_REQUEST = 400; //плохой, неверный запрос
    const UNAUTHORIZED = 401; //не авторизован (не представился)
    const PAYMENT_REQUIRED = 402; //необходима оплата
    const FORBIDDEN = 403; //запрещено (не уполномочен)
    const NOT_FOUND = 404; //не найдено
    const METHOD_NOT_ALLOWED = 405; //метод не поддерживается
    const NOT_ACCEPTABLE = 406; //неприемлемо
    const PROXY_AUTHENTICATION_REQUIRED = 407; //необходима аутентификация прокси
    const REQUEST_TIMEOUT = 408; //истекло время ожидания
    const CONFLICT = 409; //конфликт
    const GONE = 410; //удалён
    const LENGTH_REQUIRED = 411; //необходима длина
    const PRECONDITION_FAILED = 412; //условие ложно
    const PAYLOAD_TOO_LARGE = 413; //полезная нагрузка слишком велика
    const URI_TOO_LONG = 414; //URI слишком длинный
    const UNSUPPORTED_MEDIA_TYPE = 415; //неподдерживаемый тип данных
    const RANGE_NOT_SATISFIABLE = 416; //диапазон не достижим
    const EXPECTATION_FAILED = 417; //ожидание не удалось
    const IM_A_TEAPOT = 418; //я — чайник
    const AUTHENTICATION_TIMEOUT = 419; // обычно ошибка проверки CSRF (not in RFC 2616)
    const MISDIRECTED_REQUEST = 421; //
    const UNPROCESSABLE_ENTITY = 422; //необрабатываемый экземпляр
    const LOCKED = 423; //заблокировано
    const FAILED_DEPENDENCY = 424; //невыполненная зависимость
    const UPGRADE_REQUIRED = 426; //необходимо обновление
    const PRECONDITION_REQUIRED = 428; //необходимо предусловие
    const TOO_MANY_REQUESTS = 429; //слишком много запросов
    const REQUEST_HEADER_FIELDS_TOO_LARGE = 431; //поля заголовка запроса слишком большие
    const RETRY_WITH = 449; //повторить с
    const UNAVAILABLE_FOR_LEGAL_REASONS = 451; //недоступно по юридическим причинам
    const CLIENT_CLOSED_REQUEST = 499; //клиент закрыл соединение

    // 5xx: Server Error (ошибка сервера)

    const INTERNAL_SERVER_ERROR = 500; //внутренняя ошибка сервера
    const NOT_IMPLEMENTED = 501; //не реализовано
    const BAD_GATEWAY = 502; //плохой, ошибочный шлюз
    const SERVICE_UNAVAILABLE = 503; //сервис недоступен
    const GATEWAY_TIMEOUT = 504; //шлюз не отвечает
    const HTTP_VERSION_NOT_SUPPORTED = 505; //версия HTTP не поддерживается
    const VARIANT_ALSO_NEGOTIATES = 506; //вариант тоже проводит согласование
    const INSUFFICIENT_STORAGE = 507; //переполнение хранилища
    const LOOP_DETECTED = 508; //обнаружено бесконечное перенаправление
    const BANDWIDTH_LIMIT_EXCEEDED = 509; //исчерпана пропускная ширина канала
    const NOT_EXTENDED = 510; //не расширено
    const NETWORK_AUTHENTICATION_REQUIRED = 511; //требуется сетевая аутентификация
    const UNKNOWN_ERROR = 520; //неизвестная ошибка
    const WEB_SERVER_IS_DOWN = 521; //веб-сервер не работает
    const CONNECTION_TIMED_OUT = 522; //соединение не отвечает
    const ORIGIN_IS_UNREACHABLE = 523; //источник недоступен
    const A_TIMEOUT_OCCURRED = 524; //время ожидания истекло
    const SSL_HANDSHAKE_FAILED = 525; //квитирование SSL не удалось
    const INVALID_SSL_CERTIFICATE = 526; //недействительный сертификат SSL

}
