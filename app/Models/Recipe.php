<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
	use HasFactory;

	protected $fillable = [
		'name',
		'image',
		'user_id',
		'timeToPrepare',
		'portions',
		'difficulty',
		'ingredients',
		'stepsToPrepare'
	];

	public function categories()
	{
		return $this->belongsToMany(Category::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
