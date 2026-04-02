<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
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

    public function render($request, Throwable $e)
    {
        if ($this->isSessionExpiredException($e)) {
            return $this->buildSessionExpiredResponse($request);
        }

        return parent::render($request, $e);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (TokenMismatchException $e, Request $request) {
            return $this->buildSessionExpiredResponse($request);
        });
    }

    private function isSessionExpiredException(Throwable $e): bool
    {
        return $e instanceof TokenMismatchException
            || ($e instanceof HttpExceptionInterface && $e->getStatusCode() === 419);
    }

    private function buildSessionExpiredResponse(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Phiên làm việc đã hết hạn. Vui lòng tải lại trang và thử lại.',
            ], 419);
        }

        return redirect()
            ->to(url()->previous() ?: route('home'))
            ->withInput($request->except($this->dontFlash))
            ->with('error', 'Phiên làm việc đã hết hạn. Vui lòng tải lại trang và thử lại.');
    }
}
