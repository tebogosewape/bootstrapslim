<?php 

	/**
	 * This is where you put all your routes.
	 */
	 
	$app->get( '/', 'HomeController:index' )->setName('home') ;
	
	$app->get( '/register', 'AuthController:register' )->setName('register') ;
	$app->post( '/register', 'AuthController:postRegister' ) ;

	$app->get( '/login', 'AuthController:login' )->setName('login') ;
	$app->post( '/login', 'AuthController:postLogin' ) ;


