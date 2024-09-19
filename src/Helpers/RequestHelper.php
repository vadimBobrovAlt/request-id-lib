<?php

namespace bobrovva\request_id_lib\Helpers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class RequestHelper
{
    /**
     * Возвращает идентификатор запроса (request ID).
     * Если заголовок 'X-Request-ID' присутствует в запросе, то он используется.
     * В противном случае генерируется новый UUID и возвращается.
     *
     * @param string|null $prefix Необязательный префикс для идентификатора запроса.
     * @return string|null Возвращает строку с идентификатором запроса, возможно с префиксом.
     */
    public static function requestId(?string $prefix = ''): ?string
    {
        // Получаем значение из заголовка 'X-Request-ID', если его нет — генерируем UUID.
        return $prefix . Request::header('X-Request-ID', (string) Str::uuid());
    }
}