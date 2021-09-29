# Simple Examples

This file contains basic examples and explains the parameters that can be used for the components.

---

### Notification Icon

```php
<x-hermes-notification-icon type="warning" />

<x-hermes-notification-icon type="success" :notification="$notification" />
<x-hermes-notification-icon type="warning" :notification="$notification" />
<x-hermes-notification-icon type="danger" :notification="$notification" />
<x-hermes-notification-icon type="blocked" :notification="$notification" />
<x-hermes-notification-icon type="comment" :notification="$notification" />
<x-hermes-notification-icon type="mention" :notification="$notification" />

<x-hermes-notification-icon type="warning" :notification="$notification" state-color="bg-green-100" />
```
