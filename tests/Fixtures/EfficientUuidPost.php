<?php

namespace Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;

class EfficientUuidPost extends Model
{
	use GeneratesUuid;

	protected $table = 'posts';

	public $timestamps = false;

	public function uuidColumn(): string
	{
		return 'uuid';
	}

	protected $casts = [
		'uuid' => EfficientUuid::class
	];
}