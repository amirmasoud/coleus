<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Http\Client\Exception\RequestException;
use Illuminate\Http\Request;

class UploadMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        $contentType = $request->header('content-type', '');
        if (mb_stripos($contentType, 'multipart/form-data') !== false) {
            $request = $this->parseUploadedFiles($request);
        }
        return $next($request);
    }
    /**
     * Inject uploaded files defined in the 'map' key into the 'variables' key
     *
     * @param Request $request
     *
     * @return Request
     */
    private function parseUploadedFiles(Request $request): Request
    {
        $bodyParams = $request->post();
        if (!isset($bodyParams['map'])) {
            throw new RequestException('The request must define a `map`', $request);
        }
        $map = json_decode($bodyParams['map'], true);
        $result = json_decode($bodyParams['operations'], true);
        if (isset($result['operationName'])) {
            $result['operation'] = $result['operationName'];
            unset($result['operationName']);
        }
        foreach ($map as $fileKey => $locations) {
            foreach ($locations as $location) {
                $items = &$result;
                foreach (explode('.', $location) as $key) {
                    if (!isset($items[$key]) || !is_array($items[$key])) {
                        $items[$key] = [];
                    }
                    $items = &$items[$key];
                }
                $items = $request->file($fileKey);
            }
        }
        $request->headers->set('content-type', 'application/json');
        $request->json()->replace($result);
        return $request;
    }
}
