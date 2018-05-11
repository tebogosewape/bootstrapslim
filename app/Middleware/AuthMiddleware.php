<?php namespace App\Middleware ;

	/**
	 * AuthMiddleware
	 */
	
	class AuthMiddleware extends Middleware
	{
		
		public function __invoke( $request, $response, $next )
		{

			if ( !$this->container->auth->check() ) {

				$this->container->flash->addMessage( 'info', 'Sorry you need to be logged in to make this request.' ) ;

				return $response->withRedirect( $this->container->router->pathFor( 'login' ) ) ;

			}

			return $next( $request, $response ) ;

		}
	}