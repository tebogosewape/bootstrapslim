<?php 
	
	require __DIR__ . "/../vendor/autoload.php" ;

	$app 							= new \Slim\App([

		'settings' 					=> [

			'displayErrorDetails' 	=> true,

			//Configurations for eloquent.
			//
			'db'					=> [

				'driver'			=> 'mysql',
				'host'				=> 'localhost',
				'database'			=> 'milk_and_honey_db',
				'username'			=> 'root',
				'password'			=> '450411@tjS',
				'charset'			=> 'utf8',
				'collation'			=> 'utf8_unicode_ci',
				'prefix' 			=> '',

			],
		] ,

	]) ;

	// Fetch DI Container
	//
	$container 						= $app->getContainer() ;

	//Create an Eloquent instance.
	//

	$capsule 						= new \Illuminate\Database\Capsule\Manager ;
	$capsule->addConnection( $container['settings']['db'] ) ;
	$capsule->setAsGlobal() ;
	$capsule->bootEloquent() ;

	//Register capsule on the container.
	//

	$container['db'] 				= function( $container ) use ( $capsule ) { return $capsule ; } ;

	// Register Twig View helper
	//
	$container['view'] 				= function ( $c ) {

	    $view 						= new \Slim\Views\Twig( __DIR__ . '/../resources/views', [
	        'cache' 				=> false,
	    ]);
	    // Instantiate and add Slim specific extension
	    $router 					= $c->get('router');

	    $uri 						= \Slim\Http\Uri::createFromEnvironment( 
	    	new \Slim\Http\Environment( $_SERVER ) 
	    ) ;

	    $view->addExtension( 

	    	new \Slim\Views\TwigExtension( 
		    	$router, 
		    	$uri 
	    	) 

		) ;

	    return $view;
	    
	} ;

	//Binding routes to controllers
	//
	$container['HomeController'] = function( $container ) { return new \App\Controllers\HomeController( $container ) ; } ;
	$container['AuthController'] = function( $container ) { return new \App\Controllers\Auth\AuthController( $container ) ; } ;

	require __DIR__ . "/../routes/web.php" ;
