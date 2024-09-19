<?php

namespace bobrovva\request_id_lib\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RequestIdMiddleware
{
    /**
     * Обрабатывает входящий запрос, добавляя или сохраняя идентификатор запроса (Request ID).
     * Если заголовок 'X-Request-ID' отсутствует в запросе, генерируется новый UUID.
     * Идентификатор сохраняется как в заголовке запроса, так и в заголовке ответа.
     * Также идентификатор логируется для отслеживания контекста.
     *
     * @param Request $request Входящий HTTP-запрос.
     * @param Closure $next Функция для передачи управления следующему middleware.
     * @return \Symfony\Component\HttpFoundation\Response Ответ HTTP с добавленным идентификатором запроса.
     */
    public function handle(Request $request, Closure $next)
    {
        $requestId = $request->headers->get('X-Request-ID', Str::uuid()->toString());
        $request->headers->set('X-Request-ID', $requestId);
        Log::shareContext(['request-id' => $requestId]);
        $response = $next($request);
        $response->headers->set('X-Request-ID', $requestId);
        return $response;
    }
}