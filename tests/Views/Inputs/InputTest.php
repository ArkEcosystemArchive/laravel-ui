<?php

use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\ComponentAttributeBag;
use NunoMaduro\LaravelMojito\ViewAssertion;
use PHPUnit\Framework\Assert;

function createAttributes(array $attributes): array
{
    $defaults = [
        'name'   => 'username',
        'errors' => new ViewErrorBag(),
    ];

    return array_merge([
        'attributes' => new ComponentAttributeBag(array_merge($defaults, $attributes)),
    ], $defaults, $attributes);
}

it('should render with the given name', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'name' => 'username',
        ]))
        ->contains('type="text"')
        ->contains('name="username"')
        ->contains('wire:model="username"');
});

it('should render with the given label', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'label' => 'Fancy Label',
        ]))
        ->contains('Fancy Label');
});

it('should render with the given type', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'type' => 'number',
        ]))
        ->contains('type="number"');
});

it('should render with the given id', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'id' => 'uniqueid',
        ]))
        ->contains('id="uniqueid"');
});

it('should render with the given model', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'model' => 'username_model',
        ]))
        ->contains('type="text"')
        ->contains('name="username"')
        ->contains('wire:model="username_model"');
});

it('should render with the given placeholder', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'placeholder' => 'placeholder',
        ]))
        ->contains('placeholder="placeholder"');
});

it('should render with the given value', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'value' => 'value',
        ]))
        ->contains('value="value"');
});

it('should render with the given keydownEnter', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'keydownEnter' => 'function',
        ]))
        ->contains('wire:keydown.enter="function"');
});

it('should render with the given max', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'max' => 1,
        ]))
        ->contains('maxlength="1"');
});

it('should render with the given autocomplete', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'autocomplete' => 'autocomplete',
        ]))
        ->contains('autocomplete="autocomplete"');
});

it('should render as readonly', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'readonly' => true,
        ]))
        ->contains('readonly');
});

it('should render without the label', function (): void {
    ViewAssertion::macro('doesNotContain', function (string $text) {
        Assert::assertStringNotContainsString(
            (string) $text,
            $this->html,
            "Failed asserting that the text `{$text}` does not exist within `{$this->html}`."
        );

        return $this;
    });

    $this
        ->assertView('ark::inputs.input', createAttributes([
            'hideLabel' => true,
        ]))
        ->doesNotContain('<label');
});

it('should render with the given input mode', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'inputmode' => 'inputmode',
        ]))
        ->contains('inputmode="inputmode"');
});

it('should render with the given pattern', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'pattern' => 'pattern',
        ]))
        ->contains('pattern="pattern"');
});

it('should render with the given class', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'class' => 'class',
        ]))
        ->contains('<div class="class">');
});

it('should render with the given inputClass', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'inputClass' => 'inputClass',
        ]))
        ->contains('class="inputClass');
});

it('should render with the given containerClass', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'containerClass' => 'containerClass',
        ]))
        ->contains('containerClass"');
});

it('should render error styling for a label', function (): void {
    $errors = new ViewErrorBag();
    $errors->put('default', new MessageBag(['username' => ['required']]));

    $this
        ->assertView('ark::inputs.input', createAttributes([
            'errors'     => $errors,
            'inputClass' => 'inputClass',
        ]))
        ->contains('input-label--error');
});

it('should render error styling for an input', function (): void {
    $errors = new ViewErrorBag();
    $errors->put('default', new MessageBag(['username' => ['required']]));

    $this
        ->assertView('ark::inputs.input', createAttributes([
            'errors'     => $errors,
            'inputClass' => 'inputClass',
        ]))
        ->contains('input-text--error');
});

it('should render an error message', function (): void {
    $errors = new ViewErrorBag();
    $errors->put('default', new MessageBag(['username' => ['This is required.']]));

    $this
        ->assertView('ark::inputs.input', createAttributes([
            'errors'     => $errors,
            'inputClass' => 'inputClass',
        ]))
        ->contains('<p class="font-semibold input-help--error">This is required.</p>');
});

it('should render with the given slot', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'slot'   => 'Hello World',
        ]))
        ->contains('Hello World');
});

it('should render with the given slotClass', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'slot'      => 'Hello World',
            'slotClass' => 'slotClass',
        ]))
        ->contains('Hello World')
        ->contains('slotClass"');
});

it('should render a default slotClass', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'slot' => 'Hello World',
        ]))
        ->contains('Hello World')
        ->contains('h-full bg-white');
});

it('should render with the ID as label target', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'id' => 'id',
        ]))
        ->contains('for="id"');
});
