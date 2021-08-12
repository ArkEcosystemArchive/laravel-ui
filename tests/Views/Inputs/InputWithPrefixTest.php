<?php

use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use NunoMaduro\LaravelMojito\ViewAssertion;
use PHPUnit\Framework\Assert;

use function Tests\createAttributes;

it('should render with an icon', function (): void {
    $this
        ->assertView('ark::inputs.input-with-prefix', createAttributes([
            'icon' => 'brands.outline.facebook',
        ]))
        ->contains('type="text"')
        ->contains('name="username"')
        ->contains('wire:model="username"');
});

it('should render with the given name', function (): void {
    $this
        ->assertView('ark::inputs.input-with-prefix', createAttributes([
            'icon' => 'brands.outline.facebook',
            'name' => 'username',
        ]))
        ->contains('type="text"')
        ->contains('name="username"')
        ->contains('wire:model="username"');
});

it('should render with the given label', function (): void {
    $this
        ->assertView('ark::inputs.input-with-prefix', createAttributes([
            'icon'  => 'brands.outline.facebook',
            'label' => 'Fancy Label',
        ]))
        ->contains('Fancy Label');
});

it('should render with the given type', function (): void {
    $this
        ->assertView('ark::inputs.input-with-prefix', createAttributes([
            'icon' => 'brands.outline.facebook',
            'type' => 'number',
        ]))
        ->contains('type="number"');
});

it('should render with the given id', function (): void {
    $this
        ->assertView('ark::inputs.input-with-prefix', createAttributes([
            'icon' => 'brands.outline.facebook',
            'id'   => 'uniqueid',
        ]))
        ->contains('id="uniqueid"');
});

it('should render with the given model', function (): void {
    $this
        ->assertView('ark::inputs.input-with-prefix', createAttributes([
            'icon'  => 'brands.outline.facebook',
            'model' => 'username_model',
        ]))
        ->contains('type="text"')
        ->contains('name="username"')
        ->contains('wire:model="username_model"');
});

it('should render with the given placeholder', function (): void {
    $this
        ->assertView('ark::inputs.input-with-prefix', createAttributes([
            'icon'        => 'brands.outline.facebook',
            'placeholder' => 'placeholder',
        ]))
        ->contains('placeholder="placeholder"');
});

it('should render with the given value', function (): void {
    $this
        ->assertView('ark::inputs.input-with-prefix', createAttributes([
            'icon'  => 'brands.outline.facebook',
            'value' => 'value',
        ]))
        ->contains('value="value"');
});

it('should render with the given keydownEnter', function (): void {
    $this
        ->assertView('ark::inputs.input-with-prefix', createAttributes([
            'icon'         => 'brands.outline.facebook',
            'keydownEnter' => 'function',
        ]))
        ->contains('wire:keydown.enter="function"');
});

it('should render with the given max', function (): void {
    $this
        ->assertView('ark::inputs.input-with-prefix', createAttributes([
            'icon' => 'brands.outline.facebook',
            'max'  => 1,
        ]))
        ->contains('maxlength="1"');
});

it('should render with the given autocomplete', function (): void {
    $this
        ->assertView('ark::inputs.input-with-prefix', createAttributes([
            'icon'         => 'brands.outline.facebook',
            'autocomplete' => 'autocomplete',
        ]))
        ->contains('autocomplete="autocomplete"');
});

it('should render as readonly', function (): void {
    $this
        ->assertView('ark::inputs.input-with-prefix', createAttributes([
            'icon'     => 'brands.outline.facebook',
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
        ->assertView('ark::inputs.input-with-prefix', createAttributes([
            'icon'      => 'brands.outline.facebook',
            'hideLabel' => true,
        ]))
        ->doesNotContain('<label');
});

it('should render with the given input mode', function (): void {
    $this
        ->assertView('ark::inputs.input-with-prefix', createAttributes([
            'icon'      => 'brands.outline.facebook',
            'inputmode' => 'inputmode',
        ]))
        ->contains('inputmode="inputmode"');
});

it('should render with the given pattern', function (): void {
    $this
        ->assertView('ark::inputs.input-with-prefix', createAttributes([
            'icon'    => 'brands.outline.facebook',
            'pattern' => 'pattern',
        ]))
        ->contains('pattern="pattern"');
});

it('should render with the given class', function (): void {
    $this
        ->assertView('ark::inputs.input-with-prefix', createAttributes([
            'icon'  => 'brands.outline.facebook',
            'class' => 'test-input-class',
        ]))
        ->contains('class="test-input-class"');
});

it('should render with the given inputClass', function (): void {
    $this
        ->assertView('ark::inputs.input-with-prefix', createAttributes([
            'icon'       => 'brands.outline.facebook',
            'inputClass' => 'inputClass',
        ]))
        ->contains('class="inputClass');
});

it('should render with the given containerClass', function (): void {
    $this
        ->assertView('ark::inputs.input-with-prefix', createAttributes([
            'icon'           => 'brands.outline.facebook',
            'containerClass' => 'containerClass',
        ]))
        ->contains('containerClass"');
});

it('should render error styling for a label', function (): void {
    $errors = new ViewErrorBag();
    $errors->put('default', new MessageBag(['username' => ['required']]));

    $this
        ->assertView('ark::inputs.input-with-prefix', createAttributes([
            'icon'       => 'brands.outline.facebook',
            'errors'     => $errors,
            'inputClass' => 'inputClass',
        ]))
        ->contains('input-label--error');
});

it('should render error styling for an input', function (): void {
    $errors = new ViewErrorBag();
    $errors->put('default', new MessageBag(['username' => ['required']]));

    $this
        ->assertView('ark::inputs.input-with-prefix', createAttributes([
            'icon'       => 'brands.outline.facebook',
            'errors'     => $errors,
            'inputClass' => 'inputClass',
        ]))
        ->contains('input-text--error');
});

it('should render an error message', function (): void {
    $errors = new ViewErrorBag();
    $errors->put('default', new MessageBag(['username' => ['This is required.']]));

    $this
        ->assertView('ark::inputs.input-with-prefix', createAttributes([
            'icon'       => 'brands.outline.facebook',
            'errors'     => $errors,
            'inputClass' => 'inputClass',
        ]))
        ->contains('data-tippy-content="This is required."');
});

it('should render with the ID as label target', function (): void {
    $this
        ->assertView('ark::inputs.input-with-prefix', createAttributes([
            'icon' => 'brands.outline.facebook',
            'id'   => 'id',
        ]))
        ->contains('for="id"');
});
