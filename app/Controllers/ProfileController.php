<?php namespace App\Controllers ;

	use App\Models\User ;

	use Respect\Validation\Validator as v ;

	class ProfileController extends Controller {

		public function index( $request, $response ) {

			$data 								= [

				'title' 						=> 'Profile',

			] ;

			return $this->view->render( $response, 'app/profile.twig', $data );

		}

		public function postProfileUpdate( $request, $response ) {

			$validation 						= $this->validator->validate( $request, [

				'name'							=> v::notEmpty()->alpha(),
				'surname'						=> v::notEmpty()->alpha(),
				'phone_number'					=> v::notEmpty()->numeric()->phoneExists(),

			]) ;

			if ( $validation->failed() ) {

				$this->flash->addMessage( 'warning', 'Please check your form fields for any errors' ) ;

				return $response->withRedirect( $this->router->pathFor( 'profile' ) ) ;

			}

			$user 								= ( User::find( $this->auth->id() ))->update([
				'email'							=> $request->getParam( 'email' ),
				'name'							=> $request->getParam( 'name' ),
				'surname'						=> $request->getParam( 'surname' ),
				'phone_number'					=> $request->getParam( 'phone_number' ),
			]) ;

			if ( $user )
				$this->flash->addMessage( 'success', 'Profile was updated successfully.' ) ;
			else
				$this->flash->addMessage( 'warning', 'Failed to update your profile.' ) ;

			return $response->withRedirect( $this->router->pathFor( 'profile' ) ) ;
		}

		public function password_update( $request, $response ) {

			$data 								= [

				'title' 						=> 'Profile',

			] ;

			return $this->view->render( $response, 'app/change_password.twig', $data );

		}

		public function postPasswordUpdate( $request, $response ) {

			$validation 						= $this->validator->validate( $request, [

				'password'						=> v::notEmpty(),

			]) ;

			if ( $validation->failed() ) {

				$this->flash->addMessage( 'warning', 'Please check your form fields.' ) ;

				return $response->withRedirect( $this->router->pathFor( 'password_update' ) ) ;

			}

			$password 							= $request->getParam( 'password' ) ;
			$confirm_password 					= $request->getParam( 'confirm_password' ) ;


			if ( $password != $confirm_password ) {

				$this->flash->addMessage( 'warning', 'Please confirm password.' ) ;

				return $response->withRedirect( $this->router->pathFor( 'password_update' ) ) ;

			}

			$update_user 						= ( User::find( $this->auth->id() ) )->update([

				'password'						=> password_hash( $password, PASSWORD_DEFAULT )

			]) ;

			$this->flash->addMessage( 'success', 'Password was successfully changed.' ) ;

			return $response->withRedirect( $this->router->pathFor( 'password_update' ) ) ;
		}

	}