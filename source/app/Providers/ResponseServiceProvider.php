<?php

namespace App\Providers;

use App\ViewModels\ActionResultResponse;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->descriptiveResponseMethods();
    }

    protected function descriptiveResponseMethods()
    {
        $instance = $this;
        Response::macro('ok', function ($data = []) {
            return Response::json($data, 200);
        });

        Response::macro('badRequest', function ($errors = ['Validation Failure']) use ($instance) {
            return $instance->handleErrorResponse($errors, 400);
        });

        Response::macro('unauthorized', function ($errors = ['User unauthorized']) use ($instance) {
            return $instance->handleErrorResponse($errors, 401);
        });

        Response::macro('forbidden', function ($errors = ['Access denied']) use ($instance) {
            return $instance->handleErrorResponse($errors, 403);
        });

        Response::macro('notFound', function ($errors = ['Resource not found.']) use ($instance) {
            return $instance->handleErrorResponse($errors, 404);
        });

        Response::macro('internalServerError', function ($errors = ['Internal Server Error.']) use ($instance) {
            return $instance->handleErrorResponse($errors, 500);
        });
    }

    public function handleErrorResponse($errors, $status)
    {
        $response = new ActionResultResponse();

        $response->setErrors($errors);

        return Response::json($response, $status);
    }
}
