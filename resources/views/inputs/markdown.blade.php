@props([
    'name',
    'class' => null,
    'label' => null,
    'id' => null,
    'model' => null,
    'rows' => '10',
    'placeholder' => null,
    'readonly' => null,
    'message' => null,
    'required' => false,
    'slot' => null,
])

<div>
    <x-ark-textarea
        :class="$class"
        :id="$id"
        :name="$name"
        :label="$label"
        :rows="$rows"
        :model="$model"
        :placeholder="$placeholder"
        :readonly="$readonly"
        :message="$message"
        :required="$required"
    >{{ $slot ?? '' }}</x-ark-textarea>
    <span class="text-sm themetext-sm text-theme-secondary-500">{{ trans('ui::forms.github_markdown_can_be_used') }}</span>
</div>
