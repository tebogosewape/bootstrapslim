<?php namespace App\Classes ;

	class Auth {

		protected $container ;

		public function __construct( $container ) {

			$this->container = $container ;

		}

		public function __get( $property ) {

			if ( $this->container->{$property} ) {

				return $this->container->{$property} ;

			}

		}

		public function sendWelcomeEmail( $user ) {

			$template 						= 'email/auth/welcome.twig' ;

			$email_build 					= [

				'email_subject' 			=> 'Welcome',
				'btn_url'					=> false,
				'email_extra_content' 		=> false,

			] ;

			$this->mailer->send( $template, [ 

				'user' 						=> $user, 
				'email_build' 				=> $email_build, 

				], function( $message ) use ( $user ) {
			    $message->to( $user->email ) ;
			    $message->subject( 'Welcome' ) ;
		      	$message->from( getenv( "EMAIL_FROM_ADDRESS" ) ) ;
		      	$message->fromName( getenv( "EMAIL_FROM_NAME" ) ) ;
			});

		}

		public function sendForgotPasswwordEmail( $user, $app_url ) {

			$template 						= 'email/auth/reset.twig' ;

			$email_build 					= [

				'email_subject' 			=> 'Password Reset',
				'email_extra_content' 		=> 'If this was not you, please ignore the message.',
				'btn_url'					=> $app_url,
				'btn_color' 				=> '091242',
				'btn_text'					=> 'Reset Password',

			] ;

			$this->mailer->send( $template, [ 

				'user' 						=> $user, 
				'email_build' 				=> $email_build, 

				], function( $message ) use ( $user ) {
			    $message->to( $user->email ) ;
			    $message->subject( 'Password Reset' ) ;
		      	$message->from( getenv( "EMAIL_FROM_ADDRESS" ) ) ;
		      	$message->fromName( getenv( "EMAIL_FROM_NAME" ) ) ;
			});

		}

	}