<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof NotFoundHttpException) {
            return response()->json(['message' => 'A rota ' . $request->path() . ' não foi encontrada.'], $e->getStatusCode());
        }

        if ($e instanceof AuthenticationException) {
            return response()->json(['message' => 'Não autorizado.'], 401);
        }

        if ($e instanceof AuthorizationException) {
            return response()->json(['message' => 'Não autorizado.'], $e->getStatusCode());
        }

        if ($e instanceof QueryException) {
            return response()->json(['message' => 'Problema na conexão com o banco de dados', 'details' => $e->getMessage()], 500);
        }

        if ($e instanceof ValidationException) {
            return response()->json(['errors' => $e->validator->errors()->getMessages()], 422);
        }
        return parent::render($request, $e);
    }
}
