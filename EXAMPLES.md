# Simple Examples

This file contains basic examples and explains the parameters that can be used for the components.

---

## Inputs

### Input

`<x-ark-input type="email" name="my-input" :label="trans('forms.email_address')" :value="old('email')" :errors="$errors" />`

| Parameter     | Description                                                                      | Required |
|---------------|----------------------------------------------------------------------------------|----------|
| name          | input name, will also be used as `id` if none specified                          | yes      |
| errors        | laravel error bag                                                                | yes      |
| label         | label to be shown for the input, will use `trans(form.<name>)` if none specified | no       |
| type          | input type, can be the general HTML types. Defaults to `text`                    | no       |
| placeholder   | placeholder value                                                                | no       |
| value         | default value to show, can be used with laravel's `old('value')` functionality   | no       |
| model         | livewire model to attach to                                                      | no       |
| id            | id of the input, by default `name` is used                                       | no       |
| tooltip       | content of the tooltip, will be shown next to the label                          | no       |
| tooltip-class | allows additional classes for the tooltip                                        | no       |

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


### Upload Single Image
This component renders an input file for a single image upload.
```html
<x-ark-upload-image-single id="profile" :image="$image" wire:model="imageSingle" />
```
> It requires the use of a Livewire Component. 
> There is a trait that can be used with your Livewire Component `\ARKEcosystem\UserInterface\Components\UploadImageSingle`.

#### Crop functionality (optional)
1. Import the following scripts inside the `<head>` tag of your template.
```html
@push('scripts')
    <x-ark-pages-includes-crop-image-scripts />
@endpush
```

2. Copy the `crop-image.js` script into the public folder:
```js
mix
    .js('vendor/arkecosystem/ui/resources/assets/js/crop-image.js', 'public/js/crop-image.js')
```

#### How to use
```html
<x-ark-upload-image-single
    id="profile"
    :image="$image"
    wire:model="imageSingle"
    dimensions="w-64 h-64"
    upload-text="Upload Screenshot"
    delete-tooltip="Delete Screenshot"
    min-width="640"
    min-height="640"
    max-filesize="100MB"
    with-crop
    cropOptions="{
        aspectRatio: 1 / 1,
        ...
    }"
/>
```

| Parameter                    | Description                                                                      | Required |
|------------------------------|----------------------------------------------------------------------------------|----------|
| id                           | The component ID                                                                 | yes      |
| image                        | Object with the image reference (if uploaded)                                    | yes      |
| model                        | The two-bindings connection with Livewire Component                              | yes      |
| dimensions                   | Size of the upload component                                                     | no       |
| upload-text                  | Text to display when no existing image                                           | no       |
| delete-tooltip               | Tooltip text for the delete button                                               | no       |
| min-width                    | Minimum width for the image                                                      | no       |
| min-height                   | Minimum height for the image                                                     | no       |
| max-width                    | Maximum width for the image                                                      | no       |
| max-height                   | Maximum height for the image                                                     | no       |
| width                        | Width of the cropped image                                                       | no       |
| height                       | Height of the cropped image                                                      | no       |
| max-filesize                 | Maximum filesize allowed for the image                                           | no       |
| with-crop                    | Enable the crop functionality (be sure to import JS files)                       | no       |
| crop-options                 | [The cropping plugin options](https://github.com/fengyuanchen/cropperjs#options) | no       |
| crop-title                   | Crop modal title                                                                 | no       |
| crop-message                 | Crop modal message                                                               | no       |
| crop-modal-width             | Crop modal max width                                                             | no       |
| crop-cancel-button           | ID of the crop modal cancel button                                               | no       |
| crop-save-button             | ID of the crop modal save button                                                 | no       |
| crop-cancel-button-class     | Class of the crop modal cancel button                                            | no       |
| crop-save-button-class       | Class of the crop modal save button                                              | no       |
| crop-save-icon               | Whether to show or not the icon on crop modal save button                        | no       |
| crop-fill-color              | A color to fill any alpha values in the output canvas                            | no       |
| crop-image-smoothing-enabled | Set to change if images are smoothed                                             | no       |
| crop-image-smoothing-quality | Set the quality of image smoothing, one of "low" (default), "medium", or "high"  | no       |
| crop-endpoint                | Where to upload the image                                                        | no       |
| accept-mime                  | List of comma separated mime types                                               | no       |


### Upload Multiple Images
This component renders an input file for a multiple image upload.
```html
<x-ark-upload-image-collection id="media" :image="$imageCollection" wire:model="tempCollection" />
```
> It requires the use of a Livewire Component. 
> There is a trait that can be used with your Livewire Component `\ARKEcosystem\UserInterface\Components\UploadImageCollection`.

1. Install `Compressorjs`
```bash
yarn add -D compressorjs
```

2. Import the following scripts inside the `<head>` tag of your template.
```html
@push('scripts')
    <x-ark-pages-includes-compress-image-scripts />
@endpush
```

3. Copy the `compress-image.js` script into the public folder:
```js
mix
    .js('vendor/arkecosystem/ui/resources/assets/js/compress-image.js', 'public/js/compress-image.js')
```

#### Sort functionality (optional)
1. Install `Livewire Sortable`
```bash
yarn add -D livewire-sortable
```

2. Add the following snippet to your `resources/app.js`
```bash
import 'livewire-sortable'
// Or.
require('livewire-sortable')
```

3. Add `imagesReordered` method to handle index reordering when an image is sorted.
```php
public function imagesReordered(array $ids): void
{
    Media::setNewOrder($ids);
}
```

4. Then, you can use `upload-image-collection` component with sortable functionality.
```html
<x-ark-upload-image-collection 
    id="media" 
    ... 
    sortable 
/>
```

#### How to use
```
<x-ark-upload-image-collection
    id="media"
    :image="$imageCollection"
    wire:model="tempCollection"
    dimensions="w-64 h-64"
    upload-text="Upload Screenshot"
    delete-tooltip="Delete Screenshot"
    min-width="640"
    min-height="640"
    max-filesize="100MB"
    sortable
/>
```

| Parameter                    | Description                                                                                             | Required |
|------------------------------|---------------------------------------------------------------------------------------------------------|----------|
| id                           | The component ID                                                                                        | yes      |
| image                        | Object with the image reference (if uploaded)                                                           | yes      |
| model                        | The two-bindings connection with Livewire Component                                                     | yes      |
| dimensions                   | Size of the upload component                                                                            | no       |
| upload-text                  | Text to display when no existing image                                                                  | no       |
| delete-tooltip               | Tooltip text for the delete button                                                                      | no       |
| min-width                    | Minimum width for the image                                                                             | no       |
| min-height                   | Minimum height for the image                                                                            | no       |
| max-width                    | Maximum width for the image                                                                             | no       |
| max-height                   | Maximum height for the image                                                                            | no       |
| width                        | The width of the output image. If not specified, the natural width of the original image will be used   | no       |
| height                       | The height of the output image. If not specified, the natural height of the original image will be used | no       |
| max-filesize                 | Maximum filesize allowed for the image                                                                  | no       |
| quality                      | The quality of the output image. It must be a number between 0 and 1                                    | no       |
| accept-mime                  | The mime type of the upload image                                                                       | no       |
| upload-error-message         | Error message to display in case of error during the upload                                             | no       |
| sortable                     | Enable the sort functionality (be sure to import JS files)                                              | no       |

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
