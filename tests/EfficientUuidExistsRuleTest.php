<?php

namespace Tests;

use Ramsey\Uuid\Uuid;
use Tests\Fixtures\EfficientUuidPost;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EfficientUuidExistsRuleTest extends TestCase
{
	/** @test */
	public function it_passes_valid_existing_uuid()
	{
		/** @var  \Tests\Fixtures\EfficientUuidPost  $post */
		$post = factory(EfficientUuidPost::class)->create();

		/** @var  \Illuminate\Validation\Validator  $v */
		$v = Validator::make(
			['uuid' => $post->getRawOriginal('uuid')], 
			['uuid' => Rule::exists(EfficientUuidPost::class)]
		);

		$this->assertTrue($v->passes());
	}

	/** @test */
	public function it_fails_on_non_existing_uuid()
	{
		$uuid = Uuid::uuid4();

		/** @var  \Illuminate\Validation\Validator  $v */
		$v = Validator::make(
			['uuid' => $uuid->getBytes()], 
			['uuid' => Rule::exists(EfficientUuidPost::class)]
		);

		$this->assertFalse($v->passes());
	}

	/** @test */
	public function it_fails_on_any_non_uuid_invalid_strings()
	{
		$uuid = "1235123564354633";

		/** @var  \Illuminate\Validation\Validator  $v */
		$v = Validator::make(
			['uuid' => $uuid],
			['uuid' => Rule::exists(EfficientUuidPost::class, 'uuid')]
		);

		$this->assertFalse($v->passes());
	}

	/** @test */
	public function it_works_with_custom_uuid_column_name()
	{
		/** @var  \Tests\Fixtures\EfficientUuidPost  $post */
		$post = factory(EfficientUuidPost::class)->create();

		/** @var  \Illuminate\Validation\Validator  $v */
		$v = Validator::make(
			['custom_uuid' => $post->getRawOriginal('custom_uuid')], 
			['custom_uuid' => ['required', Rule::exists(EfficientUuidPost::class)]]
		);

		$this->assertTrue($v->passes());
	}
}
