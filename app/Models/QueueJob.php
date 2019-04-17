<?php namespace App\Models ;

	use Illuminate\Database\Eloquent\Model ;

	/**
	 * 
	 */
	class QueueJob extends Model
	{

		protected $table = 'queue_jobs' ;
		
		protected $fillable = [

			'subject',
			'body',
			'is_sent',
			'user_id',

		] ;

	    public function user() {

	        return $this->belongsTo( User::class ) ;

	    }

	}