<?php

namespace Dyrynda\Database\Rules;

use Ramsey\Uuid\Uuid;
use Illuminate\Contracts\Validation\Rule;

class EfficientUuidExists implements Rule
{
	/**
	 * Model's namespace
	 *
	 * @var \Illuminate\Database\Eloquent\Model
	 */
	protected $model;

	/**
	 * Specific column name from given model
	 *
	 * @var string
	 */
	protected $column;

	public function __construct(string $model, string $column = 'uuid')
	{
		$this->model = new $model;

		$this->column = $column;
	}

	public function passes($attribute, $value): bool
	{
		if (Uuid::isValid($value)) {
			return $this->model->whereUuid($value, $this->column)->exists();
		}
        
        return false;
	}

	public function message(): string
	{
		return trans('validation.exists');
	}
}
