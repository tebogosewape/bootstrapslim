<?php namespace App\Controllers ;

	class HomeController extends Controller {

		public function index( $request, $response ) {

			$data 								= [

				'title' 						=> 'Home',

			] ;

			return $this->view->render( $response, 'app/home.twig', $data );

		}


	}