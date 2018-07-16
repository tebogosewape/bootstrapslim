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

			if ( isset( $_SESSION['user'] ) )

				return $_SESSION['user'] ;

			return false ;

		}

		public function user() {

			if ( isset( $_SESSION['user'] ) )

				return User::find( $_SESSION['user'] ) ;

			return [] ;

		}

		public function logout() {
			unset( $_SESSION['user'] ) ;
		}

	}