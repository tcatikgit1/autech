<?php

namespace App\Http\Controllers;

use BadMethodCallException;
use Illuminate\Routing\ControllerMiddlewareOptions;

abstract class Controller

{

  protected $middleware = [];

  /**
   * Register middleware on the controller.
   *
   * @param  \Closure|array|string  $middleware
   * @param  array  $options
   * @return \Illuminate\Routing\ControllerMiddlewareOptions
   */
  public function middleware($middleware, array $options = [])
  {
    foreach ((array) $middleware as $m) {
      $this->middleware[] = [
        'middleware' => $m,
        'options' => &$options,
      ];
    }

    return new ControllerMiddlewareOptions($options);
  }

  public $user;
  public $lang;
  public $version;
  public function __construct()
  {
    $this->middleware(function ($request, $next) {
      $this->version = env('APP_VERSION');
      view()->share('APP_VERSION', $this->version);

      return $next($request);
    });
  }
}
