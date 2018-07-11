<?php namespace App\Auth ;

	use App\Models\User ;

	/**
	 * Auth
	 */
	
	class Auth
	{
		
		public function attempt( $email, $password )
		{
			
			$user = User::where( 'email', $email )->first() ;

			if ( !$user ) {

				return false ;

			}

			if ( password_verify( $password, $user->password ) ) {

				$_SESSION['user'] = $user->id ;

				return true ;

			}

			return false ;

		}

		public function check() {

			return isset( $_SESSION['user'] ) ;

		}

		public function id() {

			return $_SESSION['user'] ;

		}

		public function user() {

			return User::find( isset( $_SESSION['user'] ) ) ;

		}

		public function logout() {
			unset( $_SESSION['user'] ) ;
		}

	}