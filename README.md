# cleanifyChallenge 
db driven form

visit index.php to load up the main page (form)

The form is dynamically generated according to the database and the order number.

After a form is submitted, data is stored and 

an email is sent out via PHP's mail() function.

A thank you page is loaded up.

@todo: form validation--prefer JS validation to avoid another call to the server if invalid in addition to 

@todo: backend validation
@todo: backend sanitization
I've created some db fields to help with identifying the type of field (for sanitizing/escaping)

@todo: some parts of the code need to be rewritten to allow better code reuse

@todo: add routing

@todo: get .htaccess to work