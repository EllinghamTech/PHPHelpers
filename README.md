**Warning: In Development and not complete**
# Ellingham General Library for PHP
General Library for additional basic functionality for any PHP base service.

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