<?php namespace App\Classes ;

	class Contact extends Helpers {

		public function contactUs( $email, $name, $surname, $phone_number, $subject, $body ) {

			$template 						= 'email/contact.twig' ;

			$email_build 					= [

				'email_subject' 			=> 'Contact Page',
				'btn_url'					=> false,
				'email_extra_content' 		=> false,

			] ;

			$contact_details 				= [
				'email'						=> $email, 
				'name'						=> $name, 
				'surname'					=> $surname, 
				'phone_number'				=> $phone_number, 
				'subject'					=> $subject, 
				'body'						=> $body,
			] ;

			$this->mailer->send( $template, [ 

				'contact_details' 			=> $contact_details, 
				'email_build' 				=> $email_build, 

				], function( $message ) use ( $email, $name, $surname, $subject ) {
			    $message->to( getenv( "CONTACT_DETAILS" ) ) ;
			    $message->subject( 'Contact Page - ' . $subject ) ;
		      	$message->from( $email ) ;
		      	$message->fromName( $name . ' ' . $surname ) ;
			});

		}

	}