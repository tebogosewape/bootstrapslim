<?php namespace App\Controllers\Auth ;


	use Respect\Validation\Validator as v ;

	use App\Controllers\Controller ;

	use App\Models\User ;

	use App\Classes\Auth ;

	class AuthController extends Controller {

		public function register( $request, $response ) {

			$data 								= [

				'title' 						=> 'Registration',

			] ;

			return $this->view->render( $response, 'auth/register.twig', $data );

		}

		public function postRegister( $request, $response ) {

			$validation 						= $this->validator->validate( $request, [

				'email'							=> v::notEmpty()->email()->emailExists(),
				'name'							=> v::notEmpty()->alpha(),
				'surname'						=> v::notEmpty()->alpha(),
				'phone_number'					=> v::notEmpty()->numeric()->phoneExists(),
				'password'						=> v::notEmpty(),

			]) ;

			if ( $validation->failed() ) {

				$this->flash->addMessage( 'info', 'Please check your form fields for any errors' ) ;

				return $response->withRedirect( $this->router->pathFor( 'register' ) ) ;

			}

			$user 								= User::create([
				'email'							=> $request->getParam( 'email' ),
				'name'							=> $request->getParam( 'name' ),
				'surname'						=> $request->getParam( 'surname' ),
				'phone_number'					=> $request->getParam( 'phone_number' ),
				'password'						=> password_hash( $request->getParam( 'password' ), PASSWORD_DEFAULT ),
				'referral_code'					=> rand( 111111111, 999999999 ),
				'is_active'						=> 1,
				'email_token'					=> md5( rand( 111111111, 999999999 ) ),
			]) ;

			$this->HelpAuth->sendWelcomeEmail( $user ) ;

			$this->flash->addMessage( 'success', 'Account created successfully.' ) ;

			return $response->withRedirect( $this->router->pathFor( 'home' ) ) ;

		}

		public function login( $request, $response ) {

			$data 								= [

				'title' 						=> 'Login',

			] ;

			return $this->view->render( $response, 'auth/login.twig', $data );

		}

		public function postLogin( $request, $response ) {

			$auth = $this->auth->attempt( $request->getParam( 'email' ), $request->getParam( 'password' ) ) ;

			if ( $auth ) {

				$this->flash->addMessage( 'success', 'Successfully logged in.' ) ;

				return $response->withRedirect( $this->router->pathFor( 'home' ) ) ;

			}

			$this->flash->addMessage( 'warning', 'Wrong combination to authenticate to the account.' ) ;

			return $response->withRedirect( $this->router->pathFor( 'login' ) ) ;

		}

		public function reset( $request, $response ) {

			$data 								= [

				'title' 						=> 'Forgot Password',

			] ;

			return $this->view->render( $response, 'auth/reset.twig', $data );

		}

		public function postReset( $request, $response ) {

			$email 								= $request->getParam( 'email' ) ;

			if ( User::where('email', $email)->count() == 1 ) {

				$user 							= User::where( 'email', $email )->first() ;

				$email_token 					= $user->email_token ;

				$app_url 						= getenv( "APP_URL" ) . '/reset/' . $email_token ;

				$this->HelpAuth->sendForgotPasswwordEmail( $user, $app_url ) ;

				$this->flash->addMessage( 'success', 'Please check your emails for a reset link.' ) ;

			} else {

				$this->flash->addMessage( 'warning', 'Specified email not found in our records.' ) ;

			}

			return $response->withRedirect( $this->router->pathFor( 'reset' ) ) ;

		}

		public function reset_password( $request, $response, $args ) {

			$data 								= [

				'title' 						=> 'Reset Password',
				'email_token' 					=> $args[ "email_token" ],

			] ;

			return $this->view->render( $response, 'auth/reset_password.twig', $data );

		}

		public function postPasswordReset( $request, $response ) {

			$email_token 						= $request->getParam( 'email_token' ) ;
			$password 							= $request->getParam( 'password' ) ;
			$confirm_password 					= $request->getParam( 'confirm_password' ) ;


			if ( User::where('email_token', $email_token)->count() == 0 ) {

				$this->flash->addMessage( 'warning', 'Reset Token has expired, Please try and reset password again.' ) ;

				return $response->withRedirect( '/reset/' . $email_token ) ;

			}

			if ( $password != $confirm_password ) {

				$this->flash->addMessage( 'warning', 'Please confirm password.' ) ;

				return $response->withRedirect( '/reset/' . $email_token ) ;

			}

			$update_user 						= User::where('email_token', $email_token)->update([

				'password'						=> password_hash( $password, PASSWORD_DEFAULT )

			]) ;

			$this->flash->addMessage( 'success', 'Password was successfully reset.' ) ;

			return $response->withRedirect( $this->router->pathFor( 'login' ) ) ;

		}

		public function logout( $request, $response ) {

			$this->auth->logout() ;

			return $response->withRedirect( $this->router->pathFor( 'home' ) ) ;

		}

	}