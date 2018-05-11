<?php namespace App\Controllers\Auth ;


	use Respect\Validation\Validator as v ;

	use App\Controllers\Controller ;

	use App\Models\User ;

	class AuthController extends Controller {

		public function register( $request, $response ) {

			return $this->view->render( $response, 'auth/register.twig', [] );

		}

		public function postRegister( $request, $response ) {

			$validation 				= $this->validator->validate( $request, [

				'email'					=> v::notEmpty()->email()->emailExists(),
				'name'					=> v::notEmpty()->alpha(),
				'surname'				=> v::notEmpty()->alpha(),
				'phone_number'			=> v::notEmpty()->numeric()->phoneExists(),
				'password'				=> v::notEmpty(),

			]) ;

			if ( $validation->failed() ) {

				$this->flash->addMessage( 'info', 'Please check your form fields for any errors' ) ;

				return $response->withRedirect( $this->router->pathFor( 'register' ) ) ;

			}

			$user 						= User::create([
				'email'					=> $request->getParam( 'email' ),
				'name'					=> $request->getParam( 'name' ),
				'surname'				=> $request->getParam( 'surname' ),
				'phone_number'			=> $request->getParam( 'phone_number' ),
				'password'				=> password_hash( $request->getParam( 'password' ), PASSWORD_DEFAULT ),
			]) ;

			$this->flash->addMessage( 'success', 'Account created successfully.' ) ;

			return $response->withRedirect( $this->router->pathFor( 'home' ) ) ;

		}

		public function login( $request, $response ) {

			return $this->view->render( $response, 'auth/login.twig', [] );

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

		public function logout( $request, $response ) {

			$this->auth->logout() ;

			return $response->withRedirect( $this->router->pathFor( 'home' ) ) ;

		}

	}