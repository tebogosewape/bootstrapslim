<?php namespace App\Controllers ;

	use App\Models\User ;
	use App\Classes\Queue ;

	class CronController extends Controller {

	
		public function sendMail( $request, $response ) {

			$template 							= 'email/default.twig' ;

			$UnreadMail 						= Queue::unread() ;

			foreach ( $UnreadMail as $mail ) {

				$user 							= User::find( $mail->user_id ) ;

				$email_build 					= [

					'email_subject' 			=> $mail->subject,
					'body' 						=> $mail->body,
					'btn_url'					=> false,
					'email_extra_content' 		=> false,

				] ;

				$this->mailer->send( $template, [ 

					'body' 						=> $mail->body,

					'user' 						=> $user, 
					'email_build' 				=> $email_build, 

					], function( $message ) use ( $user, $mail ) {
				    $message->to( $user->email ) ;
				    $message->subject( $mail->subject ) ;
			      	$message->from( getenv( "EMAIL_FROM_ADDRESS" ) ) ;
			      	

				});

				$this->mailer->ClearAllRecipients() ;

				Queue::fire(  $mail->id ) ;

			}

		}


	}