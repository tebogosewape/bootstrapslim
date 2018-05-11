<?php 

	session_start() ;

	use Respect\Validation\Validator as v ;
	
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

	//Auth class binding.
	//
	$container['auth'] = function( $container ) { return new \App\Auth\Auth ; } ;

	//Register our validation class as a global.
	#

	$container['validator'] 		= function( $container ) { return new App\Validation\Validator ; } ;

	// Register Twig View helper
	//
	$container['view'] 				= function ( $container ) {

	    $view 						= new \Slim\Views\Twig( __DIR__ . '/../resources/views', [
	        'cache' 				=> false,
	    ]);
	    // Instantiate and add Slim specific extension
	    $router 					= $container->get('router');

	    $uri 						= \Slim\Http\Uri::createFromEnvironment( 
	    	new \Slim\Http\Environment( $_SERVER ) 
	    ) ;

	    $view->addExtension( 

	    	new \Slim\Views\TwigExtension( 
		    	$router, 
		    	$uri 
	    	) 

		) ;

		$view->getEnvironment()->addGlobal( 'auth', [

			'check' 				=> $container->auth->check(),
			'user' 					=> $container->auth->user(),

		] ) ;

	    return $view;
	    
	} ;

	//Binding routes to controllers
	//
	$container['HomeController'] = function( $container ) { return new \App\Controllers\HomeController( $container ) ; } ;
	$container['AuthController'] = function( $container ) { return new \App\Controllers\Auth\AuthController( $container ) ; } ;

	//CSRF binding.
	//
	$container['csrf'] = function( $container ) { return new \Slim\Csrf\Guard ; } ;

	//Binding routes to middleware.
	//
	$app->add( new \App\Middleware\ValidationMiddleware( $container ) ) ;
	$app->add( new \App\Middleware\InputRestoreMiddleware( $container ) ) ;
	$app->add( new \App\Middleware\CsrfMiddleware( $container ) ) ;

	$app->add( $container->csrf ) ;

	v::with( 'App\\Validation\\Rules\\' ) ;

	require __DIR__ . "/../routes/web.php" ;
