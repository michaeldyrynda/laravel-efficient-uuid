<?php

namespace Dyrynda\Database\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class EfficientUuid implements CastsAttributes
{
    /**
     * Transform the attribute from the underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return $model->resolveUuid()->fromBytes($value)->toString();
    }

    /**
     * Transform the attribute to its underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return array
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return [
            $key => $model->resolveUuid()->fromString(strtolower($value))->getBytes(),
        ];
    }
}
