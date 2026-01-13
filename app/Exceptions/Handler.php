<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{


    use ApiResponseTrait;


    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }





    public function render($request, Throwable $exception)
    {
        // Validation response for API
        if ($exception instanceof ValidationException && $request->is('api/*')) {
            $response = $this->apiResonseForMobile(
                0,
                'failed',
                $exception->errors(),
            );

            // 2️⃣ Unauthenticated user (auth middleware → login route missing)
        } elseif (
            $exception instanceof RouteNotFoundException &&
            str_contains($exception->getMessage(), 'login') &&
            $request->is('api/*')
        ) {
            $response = response()->json([
                'status'  => 0,
                'message' => 'Unauthenticated',
                'data'    => null,
            ], 401);

            // 3️⃣ Normal handling
        } else {
            $response = parent::render($request, $exception);
        }

        // Always add CORS headers so the browser never reports fake CORS errors
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Headers', '*');
        $response->headers->set('Access-Control-Allow-Methods', '*');

        return $response;
    }
}
