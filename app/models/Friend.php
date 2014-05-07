<?php

class Friend extends \Eloquent
{
	protected $fillable = [
		'first_name',
		'last_name',
		'twitter',
		'type',
		'met'
	];

	public function friender()
	{
		return $this->belongsTo('User');
	}
}