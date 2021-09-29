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

### Notification Icon

```php
<x-notification-icon type="danger" :logo="$notification->token->logo" />
<x-notification-icon type="success" :logo="$notification->token->logo" />
<x-notification-icon type="warning" :logo="$notification->token->logo" />
<x-notification-icon type="warning" :logo="$notification->token->logo" state-color="bg-green-100" />
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
