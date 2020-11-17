<?php

use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use NunoMaduro\LaravelMojito\ViewAssertion;
use PHPUnit\Framework\Assert;

it('should render with the given name', function (): void {
    $this
        ->assertView('ark::inputs.input-with-icon', [
            'name'   => 'username',
            'errors' => new ViewErrorBag(),
        ])
        ->contains('type="text"')
        ->contains('name="username"')
        ->contains('wire:model="username"');
});

it('should render with the given label', function (): void {
    $this
        ->assertView('ark::inputs.input-with-icon', [
            'name'   => 'username',
            'errors' => new ViewErrorBag(),
            'label'  => 'Fancy Label',
        ])
        ->contains('Fancy Label');
});

it('should render with the given type', function (): void {
    $this
        ->assertView('ark::inputs.input-with-icon', [
            'type'   => 'number',
            'name'   => 'username',
            'errors' => new ViewErrorBag(),
        ])
        ->contains('type="number"');
});

it('should render with the given id', function (): void {
    $this
        ->assertView('ark::inputs.input-with-icon', [
            'id'     => 'uniqueid',
            'name'   => 'username',
            'errors' => new ViewErrorBag(),
        ])
        ->contains('id="uniqueid"');
});

it('should render with the given model', function (): void {
    $this
        ->assertView('ark::inputs.input-with-icon', [
            'name'   => 'username',
            'model'  => 'username_model',
            'errors' => new ViewErrorBag(),
        ])
        ->contains('type="text"')
        ->contains('name="username"')
        ->contains('wire:model="username_model"');
});

it('should render with the given placeholder', function (): void {
    $this
        ->assertView('ark::inputs.input-with-icon', [
            'name'        => 'username',
            'placeholder' => 'placeholder',
            'errors'      => new ViewErrorBag(),
        ])
        ->contains('placeholder="placeholder"');
});

it('should render with the given value', function (): void {
    $this
        ->assertView('ark::inputs.input-with-icon', [
            'name'   => 'username',
            'value'  => 'value',
            'errors' => new ViewErrorBag(),
        ])
        ->contains('value="value"');
});

it('should render with the given keydownEnter', function (): void {
    $this
        ->assertView('ark::inputs.input-with-icon', [
            'name'         => 'username',
            'keydownEnter' => 'function',
            'errors'       => new ViewErrorBag(),
        ])
        ->contains('wire:keydown.enter="function"');
});

it('should render with the given autocomplete', function (): void {
    $this
        ->assertView('ark::inputs.input-with-icon', [
            'name'         => 'username',
            'autocomplete' => 'autocomplete',
            'errors'       => new ViewErrorBag(),
        ])
        ->contains('autocomplete="autocomplete"');
});

it('should render as readonly', function (): void {
    $this
        ->assertView('ark::inputs.input-with-icon', [
            'name'     => 'username',
            'errors'   => new ViewErrorBag(),
            'readonly' => true,
        ])
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
        ->assertView('ark::inputs.input-with-icon', [
            'name'      => 'username',
            'errors'    => new ViewErrorBag(),
            'hideLabel' => true,
        ])
        ->doesNotContain('<label');
});

it('should render with the given input mode', function (): void {
    $this
        ->assertView('ark::inputs.input-with-icon', [
            'name'      => 'username',
            'errors'    => new ViewErrorBag(),
            'inputMode' => 'inputmode',
        ])
        ->contains('inputmode="inputmode"');
});

it('should render with the given pattern', function (): void {
    $this
        ->assertView('ark::inputs.input-with-icon', [
            'name'      => 'username',
            'errors'    => new ViewErrorBag(),
            'pattern'   => 'pattern',
        ])
        ->contains('pattern="pattern"');
});

it('should render with the given class', function (): void {
    $this
        ->assertView('ark::inputs.input-with-icon', [
            'name'       => 'username',
            'errors'     => new ViewErrorBag(),
            'class'      => 'class',
        ])
        ->contains('<div class="class">');
});

it('should render with the given inputClass', function (): void {
    $this
        ->assertView('ark::inputs.input-with-icon', [
            'name'       => 'username',
            'errors'     => new ViewErrorBag(),
            'inputClass' => 'inputClass',
        ])
        ->contains('class="inputClass');
});

it('should render with the given containerClass', function (): void {
    $this
        ->assertView('ark::inputs.input-with-icon', [
            'name'           => 'username',
            'errors'         => new ViewErrorBag(),
            'containerClass' => 'containerClass',
        ])
        ->contains('containerClass"');
});

it('should render error styling for a label', function (): void {
    $errors = new ViewErrorBag();
    $errors->put('default', new MessageBag(['username' => ['required']]));

    $this
        ->assertView('ark::inputs.input-with-icon', [
            'name'       => 'username',
            'errors'     => $errors,
            'inputClass' => 'inputClass',
        ])
        ->contains('input-label--error');
});

it('should render error styling for an input', function (): void {
    $errors = new ViewErrorBag();
    $errors->put('default', new MessageBag(['username' => ['required']]));

    $this
        ->assertView('ark::inputs.input-with-icon', [
            'name'       => 'username',
            'errors'     => $errors,
            'inputClass' => 'inputClass',
        ])
        ->contains('input-text-with-icon--error');
});

it('should render an error message', function (): void {
    $errors = new ViewErrorBag();
    $errors->put('default', new MessageBag(['username' => ['This is required.']]));

    $this
        ->assertView('ark::inputs.input-with-icon', [
            'name'       => 'username',
            'errors'     => $errors,
            'inputClass' => 'inputClass',
        ])
        ->contains('<p class="font-semibold input-help--error">This is required.</p>');
});

it('should render with the given slot', function (): void {
    $this
        ->assertView('ark::inputs.input-with-icon', [
            'name'   => 'username',
            'errors' => new ViewErrorBag(),
            'slot'   => 'Hello World',
        ])
        ->contains('Hello World');
});

it('should render with the given slotClass', function (): void {
    $this
        ->assertView('ark::inputs.input-with-icon', [
            'name'      => 'username',
            'errors'    => new ViewErrorBag(),
            'slot'      => 'Hello World',
            'slotClass' => 'slotClass',
        ])
        ->contains('Hello World')
        ->contains('slotClass"');
});

it('should render a default slotClass', function (): void {
    $this
        ->assertView('ark::inputs.input-with-icon', [
            'name'      => 'username',
            'errors'    => new ViewErrorBag(),
            'slot'      => 'Hello World',
        ])
        ->contains('Hello World')
        ->contains('h-full bg-white');
});

it('should render with the ID as label target', function (): void {
    $this
        ->assertView('ark::inputs.input-with-icon', [
            'name'           => 'username',
            'errors'         => new ViewErrorBag(),
            'id'             => 'id',
        ])
        ->contains('for="id"');
});
