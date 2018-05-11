<?php 

	use App\Middleware\AuthMiddleware ;
	use App\Middleware\GuestMiddleware ;

	/**
	 * This is where you put all your routes.
	 */
	

	$app->group( '', function() {

		$this->get( '/', 				'HomeController:index' )->setName('home') ;
		$this->get( '/sendmail', 				'HomeController:sendmail' )->setName('sendmail') ;
		
		$this->get( '/register', 		'AuthController:register' )->setName('register') ;
		$this->post( '/register', 		'AuthController:postRegister' ) ;

		$this->get( '/login', 			'AuthController:login' )->setName('login') ;
		$this->post( '/login', 			'AuthController:postLogin' ) ;

	})->add( new GuestMiddleware( $container ) ) ;

	$app->group( '', function() {

		$this->get( '/dashboard', 		'HomeController:index' )->setName('dashboard') ;
		$this->get( '/logout', 			'AuthController:logout' ) ;

	})->add( new AuthMiddleware( $container ) ) ;

	


