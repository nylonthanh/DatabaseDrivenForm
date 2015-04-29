# cleanifyChallenge 
db driven form

visit index.php to load up the main page (form)

The form is dynamically generated according to the database and the order number.

After a form is submitted, data is stored and 

an email is sent out via PHP's mail() function.

A thank you page is loaded up.

config/config.php has some DB passwords, etc in. I've added it to the .gitignore but it would be something like:

const SERVER_NAME = '127.0.0.1';
const DB_NAME = '';
const DB_USER = '';
const DB_PASS = '';

const DB_FORM_TABLE = 'submission_form_contents';
const DB_FORM_DATA = 'submission_data';


@todo: form validation--prefer JS validation to avoid another call to the server if invalid in addition to 

@todo: backend validation
@todo: backend sanitization

I've created some db fields to help with identifying the type of field (for sanitizing/escaping)

@todo: some parts of the code need to be rewritten to allow better code reuse

@todo: add routing

@todo: get .htaccess to work