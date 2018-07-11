<?php 

	use App\Middleware\AuthMiddleware ;
	use App\Middleware\GuestMiddleware ;

	/**
	 * This is where you put all your routes.
	 */
	

	$app->group( '', function() {

		$this->get( '/', 							'HomeController:index' )->setName('home') ;
		$this->get( '/sendmail', 					'HomeController:sendmail' )->setName('sendmail') ;
		
		$this->get( '/register', 					'AuthController:register' )->setName('register') ;
		$this->post( '/register', 					'AuthController:postRegister' ) ;

		$this->get( '/login', 						'AuthController:login' )->setName('login') ;
		$this->post( '/login', 						'AuthController:postLogin' ) ;

		$this->get( '/password/reset', 				'AuthController:reset' )->setName('reset') ;
		$this->post( '/password/reset', 			'AuthController:postReset' ) ;

		$this->get( '/reset/{email_token}', 		'AuthController:reset_password' ) ;
		$this->post( '/reset/password', 			'AuthController:postPasswordReset' ) ;

	})->add( new GuestMiddleware( $container ) ) ;

	$app->group( '', function() {

		$this->get( '/dashboard', 					'HomeController:index' )->setName('dashboard') ;

		$this->get( '/profile', 					'ProfileController:index' )->setName('profile') ;
		$this->post( '/profile', 					'ProfileController:postProfileUpdate' ) ;

		$this->get( '/logout', 						'AuthController:logout' ) ;

	})->add( new AuthMiddleware( $container ) ) ;

	


