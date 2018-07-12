<?php namespace App\Controllers ;

	use Respect\Validation\Validator as v ;

	class ContactController extends Controller {

		public function index( $request, $response ) {

			$data 								= [

				'title' 						=> 'Contact US',

			] ;

			return $this->view->render( $response, 'front/contact.twig', $data );

		}

		public function postContact( $request, $response ) {

			$validation 						= $this->validator->validate( $request, [

				'email'							=> v::notEmpty()->email(),
				'name'							=> v::notEmpty(),
				'surname'						=> v::notEmpty(),
				'subject'						=> v::notEmpty(),

			]) ;

			if ( $validation->failed() ) {

				$this->flash->addMessage( 'info', 'Please check your form fields for any errors' ) ;

				return $response->withRedirect( $this->router->pathFor( 'contact' ) ) ;

			}

			$email								= $request->getParam( 'email' ) ;
			$name								= $request->getParam( 'name' ) ;
			$surname							= $request->getParam( 'surname' ) ;
			$phone_number						= $request->getParam( 'phone_number' ) ;
			$subject							= $request->getParam( 'subject' ) ;
			$body								= $request->getParam( 'body' ) ;

			$this->Contact->contactUs( $email, $name, $surname, $phone_number, $subject, $body ) ;

			$this->flash->addMessage( 'success', 'An email was send to the system admin, we will contact you soon.' ) ;

			return $response->withRedirect( $this->router->pathFor( 'contact' ) ) ;

		}


	}