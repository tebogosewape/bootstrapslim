<?php namespace App\Controllers ;

	class HomeController extends Controller {

		public function index( $request, $response ) {

			return $this->view->render( $response, 'master.twig', [] );

		}

		public function sendmail() {

			$user = \App\Models\User::find(7) ;

			$template = 'email/welcome.twig' ;

			$this->mailer->send( $template, ['data' => 'Tebogo Sewape', 'moreData' => '$moreData'] , function( $message ) use ( $user ) {
			      $message->to( "sewapetj@gmail.com" ) ;
			      $message->subject( 'Welcome to milk and honey.' ) ;
			      $message->from( getenv( "EMAIL_FROM_ADDRESS" ) ) ;
			      $message->fromName( getenv( "EMAIL_FROM_NAME" ) ) ;
			});

		}

	}