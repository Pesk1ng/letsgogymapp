<?php

    namespace App\Exceptions;

    use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
    use Throwable;

    class Handler extends ExceptionHandler
    {
        /**
         * Render an exception into an HTTP response.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Throwable  $exception
         * @return \Illuminate\Http\Response
         */
        public function render($request, Throwable $exception)
        {
            if ($this->isHttpException($exception)) {
                $statusCode = $exception->getStatusCode();

                if (view()->exists("errors.{$statusCode}")) {
                    return response()->view("errors.{$statusCode}", [], $statusCode);
                }
            }

            return parent::render($request, $exception);
        }
    }
