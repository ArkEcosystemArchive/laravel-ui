<?php

use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use NunoMaduro\LaravelMojito\ViewAssertion;
use PHPUnit\Framework\Assert;

use function Tests\createAttributes;

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

it('should render with a default label', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'name' => 'email',
        ]))
        ->contains('forms.email');
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
            'class' => 'test-input-class',
        ]))
        ->contains('class="test-input-class"');
});

it('should render with the given inputClass', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'inputClass' => 'inputClass',
        ]))
        ->contains('inputClass');
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
        ->contains('data-tippy-content="This is required."');
});

it('should render with the ID as label target', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'id' => 'id',
        ]))
        ->contains('for="id"');
});

it('should render with default autocapitalize to none', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([]))
        ->contains('autocapitalize="none"');
});

it('should render with the given autocapitalize', function (): void {
    $this
        ->assertView('ark::inputs.input', createAttributes([
            'autocapitalize' => 'sentences',
        ]))
        ->contains('autocapitalize="sentences"');
});
