# Ellingham PHP Helpers
Some PHP Helpers for common features used within PHP, such as Sessions and Databases.

- Database Wrapper functions (for SQL databases, MySQL/MariaDB/SQLite)
- Sessions for "NoLogin" (to store Session Messages) and "SingleUse" (for GDPR)
- Pagination - helpers for using pagination with some HTML helper methods
- Recaptcha - Simple helper for withing with Google's Recaptcha V2
- Templating - A simple templating class that does away with top.php, bottom.php etc.

Released under the MIT licence.  Use as you please but please include a copyright notice "Copyright (c) 2019 Ellingham Technologies Ltd".  This can be placed on a separate attribution page, warranties page, etc.  Under the MIT licence, we offer no warrenty for use of this library.  Public contributions to EllinghamTech/PHPHelpers are welcome.

If there are any features you believe should be added, feel free to open an issue.

## Installation
### With Composer
Using Composer (https://getcomposer.org) simply run
```
composer require ellingham-technologies/phphelpers
```

or add this line to the require section of your composer.json file and use composer to update/install:
```
"ellingham-technologies/phphelpers": "~0.5",
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
