<?php

namespace App;

use Illuminate\Contracts\Http\Kernel as HttpKernelContract;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;

class Kernel
{
    protected Application $app;
    protected HttpKernelContract $httpKernel;
    protected ?Request $currentRequest = null;
    protected $currentResponse = null;

    public function __construct()
    {
        $this->app = require __DIR__ . '/../bootstrap/app.php';
        $this->httpKernel = $this->app->make(HttpKernelContract::class);
    }

    public function boot(): void
    {
        // Bootstrapping is done in constructor, so nothing needed here
    }

    /**
     * Handle an incoming HTTP request.
     *
     * @param array $get
     * @param array $post
     * @param array $cookie
     * @param array $files
     * @param array $server
     * @return string
     */
    public function handle(array $get, array $post, array $cookie, array $files, array $server): string
    {
        // Create a Symfony Request from the superglobals
        $this->currentRequest = Request::create(
            $server['REQUEST_URI'] ?? '/',
            $server['REQUEST_METHOD'] ?? 'GET',
            $post,
            $cookie,
            $files,
            $server,
            file_get_contents('php://input')
        );

        $this->currentResponse = $this->httpKernel->handle($this->currentRequest);

        return $this->currentResponse->getContent();
    }

    /**
     * Terminate the request/response lifecycle.
     */
    public function terminate(): void
    {
        if ($this->currentRequest && $this->currentResponse) {
            $this->httpKernel->terminate($this->currentRequest, $this->currentResponse);
        }
    }

    /**
     * Shutdown the application.
     */
    public function shutdown(): void
    {
        // Perform any cleanup if necessary
        $this->app->terminate();
    }
}
