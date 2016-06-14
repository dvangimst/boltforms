Events
======

#### Extending Available Events

Should you want to provide your own extension with a data event, you can specify
a custom event name and parameters in the field definition, e.g.:

```yaml
    my_custom_field:
      type: hidden
      options:
        label: false
      event: 
        name: favourite_colour
        params:
          foo: bar 
```

The in your extension you can add a listener on the event name, prefixed with
`boltforms.` (notice the dot) and provide a callback function that provides
the data you want set in the field.

```php
public function initialize()
{
    $eventName = 'boltforms.favourite_colour';
    $this->app['dispatcher']->addListener($eventName,  array($this, 'myCustomDataProvider'));
}
```

In the callback function, you can access any passed in parameters with `$event->eventParams()`
and persist the new data with `$event->setData()`.

```php
public function myCustomDataProvider($event)
{
    $params = $event->eventParams();
    if (isset($params['foo']) && $params['foo'] === 'bar') {
        $colour = 'green';
    } else {
        $colour = 'blue';
    }
    
    $event->setData($colour);
}
```


Event Listeners
---------------

BoltForms exposes a number of listeners, that proxy Symfony Forms listeners:
  * BoltFormsEvents::PRE_SUBMIT
  * BoltFormsEvents::SUBMIT
  * BoltFormsEvents::POST_SUBMIT
  * BoltFormsEvents::PRE_SET_DATA
  * BoltFormsEvents::POST_SET_DATA

Each of these match Symfony's constants, just with the BoltForms class name/prefix.

There are also events that trigger during the data processing:
  * BoltFormsEvents::SUBMISSION_PRE_PROCESSOR
  * BoltFormsEvents::SUBMISSION_POST_PROCESSOR

Below is an example of setting a field's data to upper case on submission:

```php
<?php
namespace Bolt\Extension\You\YourExtension;

use Bolt\Extension\Bolt\BoltForms\Event\BoltFormsEvents;

class Extension extends \Bolt\BaseExtension
{
    public function initialize()
    {
        // If you want to modify data, only use the BoltFormsEvents::PRE_SUBMIT event
        $this->app['dispatcher']->addListener(BoltFormsEvents::PRE_SUBMIT,  array($this, 'myPostSubmit'));
    }
    
    public function myPostSubmit($event)
    {
        if ($event->getForm()->getName() === 'my_form') {
            // Get the data from the event
            $data = $event->getData();
            
            // Set some data values to upper case
            $data['my_field'] = strtoupper($data['my_field']);
            
            // Save the data back
            $event->setData($data);
        }
    }
}
```

Custom Event Listeners
======================

BoltForms provides a `BoltFormsEmailEvent` that is dispatched immediately 
prior to emails being sent.

This event object will contain the EmailConfig, FormConfig and FormData objects.

```php
//use Bolt\Extension\Bolt\BoltForms\Event\BoltFormsEmailEvent;

    public function initialize()
    {
        $this->app['dispatcher']->addListener(BoltFormsEvents::PRE_EMAIL_SEND,  array($this, 'myPreEmailSend'));
    }

    public function myPreEmailSend(BoltFormsEmailEvent $event)
    {
        $emailConfig = $event->getEmailConfig();
        $formConfig = $event->getFormConfig();
        $formData = $event->getFormData();
    }
```