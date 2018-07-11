<?php namespace App\Controllers ;

	use App\Models\User ;

	class ProfileController extends Controller {

		public function index( $request, $response ) {

			$data 								= [

				'title' 						=> 'Profile',

			] ;

			return $this->view->render( $response, 'app/profile.twig', $data );

		}

		public function postProfileUpdate( $request, $response ) {

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

	}