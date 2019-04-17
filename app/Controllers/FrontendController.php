<?php namespace App\Controllers ;

	class FrontendController extends Controller {

		public function index( $request, $response ) {

			$data 								= [

				'title' 						=> 'Home',

			] ;

			return $this->view->render( $response, 'front/home.twig', $data );

		}

	}