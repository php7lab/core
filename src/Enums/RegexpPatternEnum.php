<?php

namespace PhpLab\Core\Enums;

use PhpLab\Core\Domain\Base\BaseEnum;

class RegexpPatternEnum extends BaseEnum
{

    const BEGIN_REQUIRED = '#^';
    const END_REQUIRED = '$#';
    const IGNORE_CASE = 'i';

    const HEX_CHAR = '[0-9a-f]';
    const HEX = self::HEX_CHAR . '+';
    const HEX_REQUIRED = self::BEGIN_REQUIRED . self::HEX . self::END_REQUIRED;

    const UUID = '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}';
    const UUID_REQUIRED = self::BEGIN_REQUIRED . self::UUID . self::END_REQUIRED;

    const BASE_64_CHAR = '[A-Za-z0-9+/=]';
    const BASE_64 = '[A-Za-z0-9+/]{2,}[=]*';
    const BASE_64_REQUIRED = self::BEGIN_REQUIRED . self::BASE_64 . self::END_REQUIRED;

    const LOGIN = '[a-z0-9_-]{3,16}';
    const LOGIN_REQUIRED = self::BEGIN_REQUIRED . self::LOGIN . self::END_REQUIRED;

    const EMAIL = '[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}';
    const EMAIL_REQUIRED = self::BEGIN_REQUIRED . self::EMAIL . self::END_REQUIRED;

    const URL = '(?:(?:https?|ftp|telnet)://(?:[a-z0-9_-]{1,32}(?::[a-z0-9_-]{1,32})?@)?)?(?:(?:[a-z0-9-]{1,128}\.)+(?:ru|su|com|net|org|mil|edu|arpa|gov|biz|info|aero|inc|name|[a-z]{2})|(?!0)(?:(?!0[^.]|255)[0-9]{1,3}\.){3}(?!0|255)[0-9]{1,3})(?:/[a-z0-9.,_@%&?+=\~/-]*)?(?:#[^ \'\"&]*)?';
    const URL_REQUIRED = self::BEGIN_REQUIRED . self::EMAIL . self::END_REQUIRED . self::IGNORE_CASE;

    const URL_CYRILLIC = '(?:(?:https?|ftp|telnet)://(?:[а-яёa-z0-9_-]{1,32}(?::[а-яёa-z0-9_-]{1,32})?@)?)?(?:(?:[а-яёa-z0-9-]{1,128}\.)+(?:ru|su|com|net|org|mil|edu|arpa|gov|biz|info|aero|inc|name|[a-z]{2})|(?!0)(?:(?!0[^.]|255)[0-9]{1,3}\.){3}(?!0|255)[0-9]{1,3})(?:/[а-яёa-z0-9.,_@%&?+=\~/-]*)?(?:#[^ \'\"&]*)?';
    const URL_CYRILLIC_REQUIRED = self::BEGIN_REQUIRED . self::EMAIL . self::END_REQUIRED . self::IGNORE_CASE;

    const MAC_ADDRESS = '([0-9a-fA-F]{2}([:-]|$)){6}$|([0-9a-fA-F]{4}([.]|$)){3}';
    const MAC_ADDRESS_REQUIRED = self::BEGIN_REQUIRED . self::EMAIL . self::END_REQUIRED;

    const IP_V4_REQUIRED = '((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)';
    const IP_V6_REQUIRED = '((^|:)([0-9a-fA-F]{0,4})){1,8}$';

    const DOMAIN = '([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}';

    /**
     * Целые числа и числа с плавающей точкой (разделитель точка)
     */
    const NUMERIC = '\-?\d+(\.\d{0,})?';

    /**
     * Дата в формате YYYY-MM-DD
     */
    const DATE = '[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])';

    /**
     * Дата в формате YYYY-MM-DD (строгая проверка)
     */
    const DATE_STRICT = '(19|20)\d\d-((0[1-9]|1[012])-(0[1-9]|[12]\d)|(0[13-9]|1[012])-30|(0[13578]|1[02])-31)';

    /**
     * Дата в формате DD/MM/YYYY
     */
    const DATE_REVERT = '(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d';

    /**
     * Набор из цифр
     */
    const NUM = '[0-9]';
    const NUM_REQUIRED = self::BEGIN_REQUIRED . self::NUM . '+' . self::END_REQUIRED;

    /**
     * Набор из букв (латиница)
     */
    const CHAR = '[a-zA-Z]';
    const CHAR_REQUIRED = self::BEGIN_REQUIRED . self::CHAR . self::END_REQUIRED;

    /**
     * Набор из букв (латиница)
     */
    const CHAR_CYRILLIC = '[а-яА-ЯёЁa-zA-Z]';

    /**
     * Набор из букв и цифр (латиница)
     */
    const CHAR_AND_NUM = '[a-zA-Z0-9]';

    /**
     * Набор из букв и цифр (латиница + кириллица)
     */
    const CHAR_AND_NUM_CYRILLIC = '[а-яА-ЯёЁa-zA-Z0-9]';

    /**
     * Имя пользователя (с ограничением 2-20 символов, которыми могут быть буквы и цифры, первый символ обязательно буква)
     */
    const USERNAME_REQUIRED = '^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$';

    /**
     * Пароль (Строчные и прописные латинские буквы, цифры)
     */
    const PASSWORD_REQUIRED = '^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$';

    /**
     * Пароль (Строчные и прописные латинские буквы, цифры, спецсимволы. Минимум 8 символов)
     */
    const PASSWORD_STRICT_REQUIRED = '(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$';


}