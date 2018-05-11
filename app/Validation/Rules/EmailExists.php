<?php namespace App\Validation\Rules ;

	use Respect\Validation\Rules\AbstractRule ;

	/**
	 *  EmailExists
	 */
	class EmailExists extends AbstractRule
	{
		
		public function validate( $input )
		{

			return \App\Models\User::where( 'email', $input )->count() === 0 ;

		}

	}