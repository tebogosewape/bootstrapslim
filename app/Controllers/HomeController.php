<?php namespace App\Controllers ;

	use App\Models\User ;

	class HomeController extends Controller {

		public function index( $request, $response ) {

			$data 								= [

				'title' 						=> 'Dashboard',
				'users'							=> User::paginate(1),

			] ;

			return $this->view->render( $response, 'app/home.twig', $data );

		}


	}