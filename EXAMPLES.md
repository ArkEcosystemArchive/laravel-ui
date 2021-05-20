# Simple Examples

This file contains basic examples and explains the parameters that can be used for the components.

---

## Inputs

### Input

`<x-ark-input type="email" name="my-input" :label="trans('forms.email_address')" :value="old('email')" :errors="$errors" />`

| Parameter   | Description                                                                      | Required |
|-------------|----------------------------------------------------------------------------------|----------|
| name        | input name, will also be used as `id` if none specified                          | yes      |
| errors      | laravel error bag                                                                | yes      |
| label       | label to be shown for the input, will use `trans(form.<name>)` if none specified | no       |
| type        | input type, can be the general HTML types. Defaults to `text`                    | no       |
| placeholder | placeholder value                                                                | no       |
| value       | default value to show, can be used with laravel's `old('value')` functionality   | no       |
| model       | livewire model to attach to                                                      | no       |
| id          | id of the input, by default `name` is used                                       | no       |

### Textarea

`<x-ark-textarea name="my-textarea" :errors="$errors" />`

| Parameter | Description                                                                      | Required |
|-----------|----------------------------------------------------------------------------------|----------|
| name      | input name, will also be used as `id` if none specified                          | yes      |
| errors    | laravel error bag                                                                | yes      |
| label     | label to be shown for the input, will use `trans(form.<name>)` if none specified | no       |
| model     | livewire model to attach to                                                      | no       |
| rows      | amount of rows to show, defaults to 10                                           | no       |
| readonly  | whether the input is readonly or not                                             | no       |
| id        | id of the input, by default `name` is used                                       | no       |

### Checkbox

`<x-ark-checkbox name="my-checkbox" />`

| Parameter | Description                                                                      | Required |
|-----------|----------------------------------------------------------------------------------|----------|
| name      | input name, will also be used as `id` if none specified                          | yes      |
| label     | label to be shown for the input, will use `trans(form.<name>)` if none specified | no       |
| model     | livewire model to attach to                                                      | no       |
| checked   | whether the input is checked or not                                              | no       |
| disabled  | whether the input is disabled or not                                             | no       |
| id        | id of the input, by default `name` is used                                       | no       |

### Radio Button

`<x-ark-radio name="my-radio-button" />`

| Parameter | Description                                                                      | Required |
|-----------|----------------------------------------------------------------------------------|----------|
| name      | input name, will also be used as `id` if none specified                          | yes      |
| label     | label to be shown for the input, will use `trans(form.<name>)` if none specified | no       |
| model     | livewire model to attach to                                                      | no       |
| checked   | whether the input is checked or not                                              | no       |
| disabled  | whether the input is disabled or not                                             | no       |
| id        | id of the input, by default `name` is used                                       | no       |

### Toggle

`<x-ark-toggle name="my-toggle" :errors="$errors" />`

| Parameter | Description                                                                      | Required |
|-----------|----------------------------------------------------------------------------------|----------|
| name      | input name, will also be used as `id` if none specified                          | yes      |
| label     | label to be shown for the input, will use `trans(form.<name>)` if none specified | no       |
| model     | livewire model to attach to                                                      | no       |
| default   | default toggle position, defaults to `false` = unchecked                         | no       |

### Tile Selection

```
<x-ark-tile-selection
    id="tile-selection"
    title="Tile Selection"
    model="platforms"
    description="Grid boxes for multi-selection"
    :options="[
        [
            'id' => 'reddit',
            'icon' => 'brands.reddit',
            'title' => 'Reddit',
            'checked' => true,
        ],
        [
            'id' => 'youtube',
            'icon' => 'brands.youtube',
            'title' => 'Youtube',
            'checked' => false,
        ],
        [
            'id' => 'windows',
            'icon' => 'brands.windows',
            'title' => 'Windows',
            'checked' => false,
        ],
    ]"
/>
```

```
<x-ark-tile-selection
    id="categories"
    title="Category"
    model="category"
    description="Grid boxes for multi-selection"
    single
    :options="[
        [
            'id' => 'reddit',
            'title' => 'Reddit',
            'checked' => false,
        ],
        [
            'id' => 'youtube',
            'title' => 'Youtube',
            'checked' => false,
        ],
        [
            'id' => 'windows',
            'title' => 'Windows',
            'checked' => false,
        ],
    ]"
/>
```

| Parameter     | Description                                                                              | Required |
|---------------|------------------------------------------------------------------------------------------|----------|
| id            | ID used to identify tile selections                                                      | yes      |
| title         | title of options                                                                         | yes      |
| options       | array to display - requires "id", "title" & "checked" ("icon" is required if not single) | yes      |
| description   | description of options                                                                   | no       |
| model         | associates a value with livewire component                                               | no       |
| single        | only allows a single option to be selected                                               | no       |
| hiddenOptions | used for hiding options (e.g. expanding the field)                                       | no       |
| class         | allows additional classes for the component                                              | no       |

### Upload Image

```
<x-ark-upload-image
    :image="$image"
    dimensions="w-64 h-64"
    upload-text="Upload Screenshot"
    delete-tooltip="Delete Screenshot"
    min-width="640"
    min-height="640"
    max-filesize="100MB"
    with-crop
    cropOptions="{ aspectRatio: 1 / 1 }"
    cropTitle="Crop Image"
    cropMessage="Select the area of the image you want to use."
/>
```

| Parameter                | Description                                              | Required |
|--------------------------|----------------------------------------------------------|----------|
| image                    | Object with the image reference (if uploaded)            | yes      |
| dimensions               | Size of the upload component                             | no       |
| upload-text              | Text to display when no existing image                   | no       |
| delete-tooltip           | Tooltip text for the delete button                       | no       |
| min-width                | Minimum width for the image                              | no       |
| min-height               | Minimum height for the image                             | no       |
| max-filesize             | Maximum filesize allowed for the image                   | no       |
| with-crop                | Enable the crop functionality                            | no       |
| crop-options             | The options for cropping                                 | no       |
| crop-title               | Crop modal title                                         | no       |
| crop-message             | Crop modal message                                       | no       |
| crop-modal-width         | Crop modal max width                                     | no       |
| crop-cancel-button       | ID of the crop modal cancel button                       | no       |
| crop-save-button         | ID of the crop modal save button                         | no       |
| crop-cancel-button-class | class of the crop modal cancel button                    | no       |
| crop-save-button-class   | class of the crop modal save button                      | no       |
| crop-save-icon           | wheter to show or not the icon on crop modal save button | no       |

#### Backend

This component requires the use of a Livewire component. There is an abstract class that can be extended to provide this functionality:

```
<?php

use ARKEcosystem\UserInterface\Components\UploadImage;

class UpdateScreenshot extends UploadImage
{
    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('forms.update-screenshot-form');
    }

    /**
     * Override default validators - 100mb
     *
     * @return array
     */
    public function validators()
    {
        return ['mimes:jpeg,png,bmp,jpg', 'max:102400'];
    }

    /**
     * Store image
     */
    public function store()
    {
        //
    }

    /**
     * Delete image
     */
    public function delete()
    {
        //
    }
}

```

---

## Navigation

### Navbar

`<x-ark-navbar title="Deployer" :navigation="[['route' => 'tokens', 'label' => trans('menus.dashboard')]]" />`

| Parameter  | Description                                                          | Required |
|------------|----------------------------------------------------------------------|----------|
| title      | used for the "ARK <title>" navbar text                               | yes      |
| navigation | an array of `route`, `label` pairs for the navbar navigation options | yes      |

### Breadcrumbs

> Note: this works best when using a breadcrumb section in your layout view to which you pass the breadcrumb itself on different pages

```php
<x-ark-breadcrumbs :crumbs="[
    ['route' => 'tokens', 'label' => trans('menus.dashboard')],
    ['route' => 'tokens.welcome', 'label' => trans('menus.onboarding'), 'params' => [$token]],
    ['route' => 'tokens.identity', 'label' => trans('menus.tokens.identity'), 'params' => [$token]],
]" />
```

### Sidebar Links

> Sidebar links that automatically change class when they correspond to the active route

`<x-ark-sidebar-link :name="trans('menus.tokens.networks')" route="tokens.show" :params="[$token]" />`

---

## Misc Components

### Alerts

> Note: Requires various icons to be present to properly work. Relies on [Blade SVG](https://github.com/adamwathan/blade-svg) to load them.

Simple usage with a string message, optionally you can pass a "title" property:

`<x-ark-alert :type="flash()->class" :message="flash()->message" />`

Additionally, you can also make use of slots:

```php
<x-ark-alert type="alert-info" title="Notification">
    <x-slot name="message">
        {!! trans('tokens.networks.no_source_provider_alert', ['route' => route('tokens.source-providers', $selectedToken)]) !!}
    </x-slot>
</x-ark-alert>
```

You can also get an alert with more padding and large icon by specifying `large`:

```php
<x-ark-alert type="alert-info" title="Notification" large>
    <x-slot name="message">
        {!! trans('tokens.networks.no_source_provider_alert', ['route' => route('tokens.source-providers', $selectedToken)]) !!}
    </x-slot>
</x-ark-alert>
```

### Accordion

```php
<x-ark-accordion-group slots="2">
    @slot('title_1')
        <p>Title for slot 1</p>
    @endslot
    @slot('slot_1')
        <p>Content for slot 1</p>
    @endslot

    @slot('title_2')
        <p>Title for slot 2</p>
    @endslot
    @slot('slot_2')
        <p>Content for slot 2</p>
    @endslot
</x-ark-accordion-group>
```

```php
<x-ark-accordion title="Title">
    <p>Content for slot</p>
</x-ark-accordion>
```

### Clipboard

```php
<x-ark-clipboard :value="$this->user->password" />
```

### Icon

```php
<x-icon name="chevron-down" size="xs" class="md:h-3 md:w-2" />
```

### Simple Footer

> Only contains date, copyright notice and an ARK.io link

`<x-ark-simple-footer />`

### Settings Dropdown

```php
<div class="relative">
    <x-settings-dropdown button-class="icon-button w-10 h-10">
        <button class="settings-dropdown-entry">@lang('actions.start')@svg('plus', 'h-3 w-3 ml-2')</button>
        <button class="settings-dropdown-entry">@lang('actions.stop')@svg('minus', 'h-3 w-3 ml-2')</button>
        <button class="settings-dropdown-entry">@lang('actions.reboot')@svg('reload', 'h-3 w-3 ml-2')</button>
    </x-settings-dropdown>
</div>
```

### Dropdown

```blade
<x-ark-dropdown>
    <div>content here</div>
<x-ark-dropdown />
```

| Parameter | Description | Required | Default Value |
|---|---|---|---|
| dropdownProperty | The variable name used by Alpine.js | no | 'dropdownOpen' |
| initAlpine | Enable the dropdown functionality | no | true |
| closeOnBlur | Enable the close-on-blur functionality | no | true |
| closeOnClick | Enable the close-on-click functionality | no | true |
| dusk | Apply a Dusk property for Dusk Tests | no | null |
| button | Override the default trigger button | no | false |
| height | Specify height for the content container | no | false |
| fullScreen | Cover the entire horizontal viewport on smaller screen (until md) | no | false |
| buttonClass | The class(es) applied to the trigger button | no | 'text-theme-primary-500' |
| buttonClassExpanded | The class(es) applied to the trigger button when content is visible  | no | 'text-theme-secondary-400 hover:text-theme-primary-500' |
| wrapperClass | The class(es) applied to the wrapper element | no | '' |
| dropdownContentClasses | The class(es) applied to the content container | no | null |
| buttonTooltip | Apply the given text as button tooltip | no | null |

### Expandable
Displays a defined number of items and hides the rest, showing a button to show/hide the hidden items.
It's possible to add placeholders and define when to show/hide them via css.
The remaining items counter is automatically generated and can be displayed by adding a helper css class (2 helpers available).
- `counter-before` prepends the counter inside the element.
  _E.g. if the remaining items are 7_

```blade
<span class="counter-before">+</span>
<!-- outputs -->
<span class="counter-before">7+</span>
```

- `counter-after` appends the counter inside the element.
  _E.g. if the remaining items are 7_

```blade
<span class="counter-after">+</span>
<!-- outputs -->
<span class="counter-after">+7</span>
```

As optional, an increment counter is automatically generated too and can be displayed by adding a helper css class (2 helpers available).
- `increment-before` prepends the increment inside the element.
  _E.g. for the 3rd item_

```blade
<span class="increment-before">.</span>
<!-- outputs -->
<span class="increment-before">3.</span>
```

- `increment-after` appends the increment inside the element.
  _E.g. for the 3rd item_

```blade
<span class="increment-after">.</span>
<!-- outputs -->
<span class="increment-after">.3</span>
```

> Remember to wrap the items in `<x-ark-expandable-item>...</x-ark-expandable-item>` component.

```blade
<x-ark-expandable total="12">
    @foreach($items as $item)
        <x-ark-expandable-item>
            ...
        </x-ark-expandable-item>
    @endforeach

    <x-slot name="placeholder">
        ...
    </x-slot>

    <x-slot name="collapsed">
        <span>
            <!-- this append the counter after the "+" symbol -->
            <span class="counter-after">+</span>
            <span>show more</span>
        </span>
    </x-slot>

    <x-slot name="expanded">
        <span>hide</span>
    </x-slot>
</x-ark-expandable>
```

| Parameter | Description | Required | Default Value |
|---|---|---|---|
| total | Total count of items in the collection | yes | |
| triggerDusk | Specify a trigger name used by Dusk | no | null |
| triggerClass | The class(es) applied to the trigger element | no | '' |
| collapsedClass | The class(es) applied to the collepsed element | no | '' |
| expandedClass | The class(es) applied to the expanded element | no | '' |
| collapsed | The collapsed element | no | null |
| expanded | The expanded element | no | null |
| placeholder | The placeholder element | no | null |
| placeholderCount | Total copy of placeholder | no | 1 |
| showMore | Implement your own show/hide system | no | null |
| style | Useful to inject css variable(s) | no | '' |


### Font Loader
Improve font loading times.
> This component is inspired by [Harry Roberts' article](https://csswizardry.com/2020/05/the-fastest-google-fonts/).

Here follow you can see an example on how to use it:
```blade
{{-- an example with a custom font --}}
<x-ark-font-loader src="https://rsms.me/inter/inter.css">
```

```blade
{{-- an example with a google font --}}
<x-ark-font-loader src="https://fonts.googleapis.com/css2?family=Inter&display=swap" preconnect="https://fonts.gstatic.com">
```

```blade
{{-- an example with a google font, omitting the `&display=swap`. It'll be appended automatically for Google Fonts! --}}
<x-ark-font-loader src="https://fonts.googleapis.com/css2?family=Inter" preconnect="https://fonts.gstatic.com">
```

| Parameter | Description | Required | Default Value |
|---|---|---|---|
| src | The source of the font file | yes | |
| preconnect | The source of the css file linked to the font itself. Can be different from the font source. | no | null |
