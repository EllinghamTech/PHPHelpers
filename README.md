**Warning: In Development and not complete**
# Ellingham General Library for PHP
General Library for additional basic functionality for any PHP base service.

## Installation
### With Composer
Using Composer (https://getcomposer.org) simply run
```
composer require ellingham-technologies/phphelpers
```

or add this line to the require section of your composer.json file and use composer to update/install:
```
"ellingham-technologies/phphelpers": "~0.1",
```

*As this is early days, we should point out that the library is quite limited.  You can use the "dev-master" release (which is the latest and greatest) - but this could always lead to site-breakages if there is an error somewhere in the development library - so don't use on production sites.*

### Without Composer
Not a problem!

We've included a custom AutoLoader (src/EllinghamTech/AutoLoad.php) that can be used or you can
include the classes individually as you please. 

#### Using the AutoLoader
Simply include the AutoLoad.php file and start using!

```php
require('/path/to/EllinghamTech/AutoLoad.php');
$template = new EllinghamTech/Templating/Template('My Website!'); // Template class is now autoloaded by PHP
```

#### Without the AutoLoader (not recommended)
Ensure you include any require interfaces and abstract classes, etc.

E.g.
```php
require('/path/to/EllinghamTech/Session/IBasicSession.php'); // Interface used by SingleUse session class
require('/path/to/EllinghamTech/Session/SingleUse.php');

$singleUseSession = new EllinghamTech/Session/SingleUse();
$singleUseSession->setSessionMessage('contact-us', 'Please check all the fields to ensure you have entered the correct details');
```

# What's Inside

## Sessions
### No Login
NoLogin is a basic session wrapper that deals with holder user error messages and notifications.

### SingleUse
SingleUse was created becuase of GDPR.  It is a NoLogin based session wrapper but only keeps a
session active for two loads - the first creates the second and on the second load it will destroy
the session.

**An example of usage would be:**

myContactUsFormProcessPage.php - Processes the contact us form and generates a success message on
completion or error message on failure.  Stores these messages using EllinghamTech\Session\SingleUse

myContactUsPage.php - Begins SingleUse but only reads notification data.  If an error or success is
found then show the user this message.  Session is destroyed.  GDPR complete - no cookies stored for
more than 1 page view.

- [ ] SingleUse without cookies (using browser ID)?
- [ ] SingleUse storing all notification data in browser?

## Templating
### Template
The Template class provides a basic wrapper for website templating.  Designed so that you can include()
a template page that then accesses the Template instance to write the page content.

Designed to replace the idea of Wordpress' top.php bottom.php malarkey.
