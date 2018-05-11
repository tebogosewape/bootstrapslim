<?php namespace App\Middleware ;

	/**
	 * GuestMiddleware
	 */
	
	class GuestMiddleware extends Middleware
	{
		
		public function __invoke( $request, $response, $next )
		{

			if ( $this->container->auth->check() ) {

				return $response->withRedirect( $this->container->router->pathFor( 'dashboard' ) ) ;

			}

			return $next( $request, $response ) ;

		}
	}