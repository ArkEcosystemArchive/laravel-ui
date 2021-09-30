<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Eloquent\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\SchemalessAttributes\SchemalessAttributes;

trait HasSchemalessAttributes
{
    public function getExtraAttributesAttribute(): SchemalessAttributes
    {
        return SchemalessAttributes::createForModel($this, 'extra_attributes');
    }

    public function scopeWithExtraAttributes(): Builder
    {
        return SchemalessAttributes::scopeWithSchemalessAttributes('extra_attributes');
    }

    public function getMetaAttribute($name, $default = null)
    {
        return $this->extra_attributes->get($name, $default);
    }

    public function setMetaAttribute($name, $value)
    {
        $this->extra_attributes->set($name, $value);

        $this->save();
    }

    public function hasMetaAttribute($name)
    {
        return ! empty($this->extra_attributes->get($name));
    }

    public function forgetMetaAttribute($name)
    {
        $this->extra_attributes->forget($name);

        $this->save();
    }

    public function fillMetaAttributes($attributes)
    {
        foreach ($attributes as $name => $value) {
            $this->extra_attributes->set($name, $value);
        }

        $this->save();
    }

    public static function updateOrCreateWithMeta(array $attributes, array $values): Model
    {
        $model = static::withExtraAttributes($attributes)->first();

        if ($model) {
            $model->update($values);
        } else {
            $model = static::create($values);
        }

        return $model->fresh();
    }
}
