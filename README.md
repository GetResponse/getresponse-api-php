## Overview

GetResponse API v3 wrapper working on PHP 5.2+.
[Here](http://apidocs.getresponse.com/en/v3/) you can find our api documentation.

##Examples

Standard authorization
```php
$getresponse = new GetResponse('your_api_key');
```
--

Enterprise authorization
```php
$getresponse = new GetResponse('your_api_key');
$getresponse->enterprise_domain = 'somedomain.com';

//api URL is relative to your domain UR:
$getresponse->api_url = 'https://api3.getresponse360.pl/v3'; //for PL domains
$getresponse->api_url = 'https://api3.getresponse360.com/v3'; //default
```
--
Search contacts
```php
$result = $getresponse->getContacts(array(
	'query' => array(
		'email' => '@getresponse.com',
	),
	'fields' => 'name,email'
));
```


Add contact
```php
$getresponse->addContact(array(
    'name'              => 'Jon Smith',
    'email'             => 'jonsmith@testdomain.com',
    'dayOfCycle'        => 0,
    'campaign'          => array('campaignId' => 'campaign_id_obtained_by_API'),
    'ipAddress'         => '89.206.31.190',
    'customFieldValues' => array(
        array('customFieldId' => 'custom_field_id_obtained_by_API',
            'value' => array(
                'Y'
            )),
         array('customFieldId' => 'custom_field_id_obtained_by_API',
            'value' => array(
                'Y'
            ))
    )
));
```
--
Send message
```php
$result = $getresponse->sendNewsletter(array(
				"subject" => 'Test subject',
				"fromField" => array('fromFieldId' => 'from_field_id'),
				"content" => array(
					'html' => 'Test newsletter contetnt.'
				),
				"sendSettings" => array(
					"selectedContacts" => array('contact_id_obtained_by_API')
			)
    ));
```
--
Add custom field
```php
$getresponse->setCustomField(array(
				'name' => 'custom_name',
				'type' => 'text',
				'hidden' => 'false',
    ));
```
--
List saved search
```php
$result = $getresponse->searchContacts();
```
--
List new web forms
```php
$result = $getresponse->getForms();
```
--
List old web forms
```php
$result = $getresponse->getWebForms();
```



