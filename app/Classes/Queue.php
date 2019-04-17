<?php namespace App\Classes ;

	use App\Models\QueueJob ;
	use App\Models\User ;

	class Queue {


		public static function add( $subject, $body, $user_id ) {

			QueueJob::create([

				'subject' 				=> $subject,
				'body' 					=> $body,
				'is_sent' 				=> 0,
				'user_id' 				=> $user_id,

			]) ;

		}


		public static function unread() {

			return QueueJob::where( 'is_sent', 0 )->orderBy('created_at', 'desc')->get() ;

		}


		public static function mailByUser( $user_id ) {

			return QueueJob::where( 'is_sent', 0 )->where( 'user_id', $user_id )->orderBy('created', 'desc')->get() ;

		}


		public static function fire( $id ) {

			$mail 						= QueueJob::find( $id ) ;

			$mail->update(['is_sent' => 1]) ;

			return true ;

		}



	}