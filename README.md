# cleanifyChallenge
 
## Objective: 

Create a database-driven form.

## Assumptions:

* PHP/MySQL db is running (on PHP 5.6.6, MySQL 5.5.42)
* config/config.php must be created and add constants -DB info, email, etc (.gitignore)

/config/config.php sample 
 const SERVER_NAME = '127.0.0.1';
 const DB_NAME = '';
 const DB_USER = '';
 const DB_PASS = '';
 const DB_FORM_TABLE = 'submission_form_contents';
 const DB_FORM_DATA = 'submission_data';
 
 const EMAIL_FORM = 'you@example.com';
 
 
## Directions: 

 1.) visit index.php to load up the main page (form)
 
 2.) The form is dynamically generated according to the database and the order number.
 
 3.) After a form is submitted, data is stored and 
 
 4.) an email is sent out via PHP's mail() function.
 
 5.) A thank you page is loaded up.
 
 *.) error page loaded up 
 
 *.) requires something in the fields to be submitted (both backend and HTML validation)

## NOTES:

* Time is stored as epoch UTC time in the database when record is added.
* Time is stored as default MySql format (e.g. 2015-04-29 15:51:05) for modiefied date

## TODO:

@todo: add caching

@todo: add routing
