<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Response;
use App\Helpers\ResponseObject;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Client\RequestException;
use App\Exceptions\CustomException;
use App\Exceptions\BadRequestException;


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

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->wantsJson()) {
                $response = new ResponseObject();
            if ($exception instanceof BadRequestException) {
                $response->errorMessage = $exception->getBadRequestMassege();
                $response->statusCode = Response::HTTP_BAD_REQUEST;
            } elseif ($exception instanceof ModelNotFoundException) {
                $response->errorMessage = 'You try to get model (' . $exception->getModel() . ') by wrong id.';
                $response->statusCode = Response::HTTP_NOT_FOUND;
            } elseif ($exception instanceof AuthorizationException) {
                $response->errorMessage = 'This action is unauthorized';
                $response->statusCode = Response::HTTP_FORBIDDEN;
            } elseif ($exception instanceof ValidationException) {
                $errorMessages = [];
                foreach ($exception->validator->errors()->getMessages() as $errors)
                    foreach ($errors as $message)
                        $errorMessages[] = $message;
                $response->errorMessage = $errorMessages;
                $response->statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
            } elseif ($exception instanceof HttpException) {
                $response->errorMessage = $exception->getMessage();
                $response->statusCode = Response::HTTP_NOT_FOUND;
            } elseif ($exception instanceof RequestException) {
                $response->errorMessage = $exception->getMessage();
                $response->statusCode = Response::HTTP_NOT_FOUND;
            } elseif ($exception instanceof CustomException) {
                $response->errorMessage = $exception->getCustomMassege();
                $response->statusCode = $exception->getStatusCode();
            } elseif ($exception instanceof TokenInvalidException) {
                $response->errorMessage = $exception->getMessage();
                $response->statusCode = 441;
            } elseif ($exception instanceof TokenExpiredException) {
                $response->errorMessage = $exception->getMessage();
                $response->statusCode = 442;
            } elseif ($exception instanceof OAuthServerException || $exception instanceof AuthenticationException) {
                $response->errorMessage = 'unauthenticated';
                $response->statusCode = Response::HTTP_UNAUTHORIZED;
            } elseif ($exception instanceof GoneHttpException) {
                $response->errorMessage = 'not exist';
                $response->statusCode = Response::HTTP_GONE;
            }else {
                if (App::environment('local', 'test')) {
                    $response->errorSource = $exception->getFile() . '' . $exception->getLine();
                    if (strpos($response->errorSource, 'stripe-php') !== false) {
                        $response->errorMessage = $exception->getMessage();
                        $response->statusCode = 450;
                    } else {
                        $response->errorMessage = $exception->getMessage();
                        $response->statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                    }
                } else {
                    $response->errorMessage = 'We encounter some issues please contact our support team.';
                    $response->statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                }
            }
            $response->errored = true;
            return response()->json($response, $response->statusCode);

            return parent::render($request, $exception);

        } else {
            return parent::render($request, $exception);
        }

    }
}
