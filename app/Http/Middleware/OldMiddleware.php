<?php namespace chineseClass\Http\Middleware;

use Closure;
use Response;
use Route;

class OldMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$age = $request->route()->getParameter('age');
		if ($age <= 18)
        {
            return redirect('home');
        }
		return $next($request);
	}

}
