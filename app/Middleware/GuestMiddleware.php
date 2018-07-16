<?php namespace App\Middleware ;

	/**
	 * GuestMiddleware
	 */
	
	class GuestMiddleware extends Middleware
	{
		
		public function __invoke( $request, $response, $next )
		{

			if ( $this->auth->check() ) {

				return $response->withRedirect( $this->router->pathFor( 'dashboard' ) ) ;

			}

			return $next( $request, $response ) ;

		}
	}