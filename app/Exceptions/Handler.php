<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
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
        $this->renderable(function (NotFoundHttpException $e, $request) { // @pest-ignore-type
            if ($request->wantsJson()) {
                $model = Str::of($e->getMessage())
                    ->between('[', ']')
                    ->afterLast('\\');

                return response()->json(
                    [
                        'message' => 'Entry for ' . $model . ' not found.',
                    ],
                    ResponseAlias::HTTP_NOT_FOUND
                );
            }
        });
    }
}
