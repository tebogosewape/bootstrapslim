<?php 

	use App\Middleware\AuthMiddleware ;
	use App\Middleware\GuestMiddleware ;

	/**
	 * This is where you put all your routes.
	 */
	

	$app->group( '', function() {

		$this->get( '/', 							'HomeController:index' )->setName('home') ;
		
		$this->get( '/register', 					'AuthController:register' )->setName('register') ;
		$this->post( '/register', 					'AuthController:postRegister' ) ;

		$this->get( '/login', 						'AuthController:login' )->setName('login') ;
		$this->post( '/login', 						'AuthController:postLogin' ) ;

		$this->get( '/password/reset', 				'AuthController:reset' )->setName('reset') ;
		$this->post( '/password/reset', 			'AuthController:postReset' ) ;

		$this->get( '/reset/{email_token}', 		'AuthController:reset_password' ) ;
		$this->post( '/reset/password', 			'AuthController:postPasswordReset' ) ;

		$this->get( '/contact_us', 					'ContactController:index' )->setName('contact') ;
		$this->post( '/contact_us', 				'ContactController:postContact' ) ;

		$this->get( '/cron/send/mail', 				'CronController:sendMail' )->setName('send_mail') ;

	})->add( new GuestMiddleware( $container ) ) ;

	$app->group( '', function() {

		$this->get( '/dashboard', 					'HomeController:index' )->setName('dashboard') ;

		$this->get( '/profile', 					'ProfileController:index' )->setName('profile') ;
		$this->post( '/profile', 					'ProfileController:postProfileUpdate' ) ;

		$this->get( '/password/update', 			'ProfileController:password_update' )->setName('password_update') ;
		$this->post( '/password/update', 			'ProfileController:postPasswordUpdate' ) ;

		$this->get( '/logout', 						'AuthController:logout' ) ;

	})->add( new AuthMiddleware( $container ) ) ;
