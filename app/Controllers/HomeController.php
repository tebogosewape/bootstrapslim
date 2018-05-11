<?php namespace App\Controllers ;

	class HomeController extends Controller {

		public function index( $request, $response ) {

			return $this->view->render( $response, 'master.twig', [] );

		}

		public function sendmail() {

			$user = \App\Models\User::find(7) ;

			$template = 'email/welcome.twig' ;

			try {

				$this->mailer->send( $template, ['data' => 'Tebogo Sewape', 'moreData' => '$moreData'] , function( $message ) use ( $user ) {
				      $message->to( $user->email ) ;
				      $message->subject( 'Welcome to milk and honey.' ) ;
				      $message->from( 'info@milkandhoney.org.za' ) ; // if you want different sender email in mailer call function
				      $message->fromName( 'Milk and honey' ) ; // if you want different sender name in mailer call function
				});

			    echo 'Message has been sent';
			} catch (Exception $e) {
			    echo 'Message could not be sent. Mailer Error: ', $this->mailer->ErrorInfo;
			}

		}

	}