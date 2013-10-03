# Saasu API PHP Client


## 1. Overview

This is a PHP Client library for [**Saasu**](http://www.saasu.com), the online accounting software. Full API documentation is available at <http://help.saasu.com/api/>

This library is designed to make it easy to work with the  Saasu API for general purpose.

## 2. Installation

With composer, add to your composer.json :

```
{
    "require": {
        "dlin/saasu": "dev-master"
    }
}
```

If you are new to [composer](http://getcomposer.org/), here is some simple steps to take.

1. Download *composer.phar* from the above link
2. Create a json file named *composer.json* containing just exactly the above "require" block
3. Having *composer.phar* and *composer.json* side by side, you can run the command:
```
php ./composer.phar install
```
4. The composer will create a directory named *vendor* and download all required libraries into it.

5. In the *vendor* directory, there's also a file named *autoload.php*. This is the PHP autoloader for the libraries inside. You might need to register it to you existing autoloader, or include it manually.





## 3. Usage
This library, hereafter refered to as **Saasu PHP Client**, comes with a very simple interface with methods for interacting with Saasu API to load, insert, update, search, and delete entities.

#### Instantiate the main api instance

```

// You will need to include this autoload script manually
// if you don't have any autoloader setup.
include "../path/to/vendor/autoload.php"; 

// one needs to declear the namespace for each class used 
use Dlin\Saasu\SaasuAPI;

// You can obtain accesskey and fileUid from your account at:
// https://secure.saasu.com/a/net/webservicessettings.aspx
$wsaccesskey = 'D4A92597762C4FDCAF66FF03C988B7B2';
$fileUid = '41555';


//Instantiate the main class for later use
$api = new SaasuAPI($wsaccesskey, $fileUid);
...

```
####  Create ( insert ) an entity
```
//Create an entity object
$bankAccount = new BankAccount();

//Sets entity properties
$bankAccount->type = AccountType::Income;
$bankAccount->name = "Test Name";"
$bankAccount->displayName = "Test Account";
$bankAccount->bsb = 123456;
$bankAccount->accountNumber = 123123123;

//Save the new entity, i.e. create the entity
$api->saveEntity($bankAccount);
```

The *save()* method takes an entity object (See bellow for more details) and persists  object properties. The *save()* method works out a 'create' operation or 'update' operation by inspecting the *uid* property of the entity object. If the entity object have a *null* *uid* property, a new entity will be created. If the entity object have a numeric *uid* property, which indicates an existing entity object, the existing entity object will be updated.

#### Update an entity
```
//change some value of an existing entity with a uid
echo $bankAccount->uid; //prints 23456,
$bankAccount->name = "Updated Name";

//Save the change
$api->saveEntity($bankAccount);
```


#### Updating and Inserting entities in bulk
The **Saasu PHP Client** allows updating and inserting multiple entities in one request. This is supported by the *saveEntities* method, which takes an array of entity objects to update or insert. You can mix existing entities and new entities into one array and perform the update and create actions at the same time in one single request. Entities do not need to be of the same type in the array.

```
//an account to create
$bankAccount = new BankAccount();
$bankAccount->type = AccountType::Income;
$bankAccount->name = "Test Name";"
$bankAccount->displayName = "Test Account";
$bankAccount->bsb = 123456;
$bankAccount->accountNumber = 123123123;


//an account to update
echo $existingAccount->uid; //prints 4354323;
$existingAccount->name = "Updated Name";
$existingAccount->displayName = "Another Account";


//perform bulk operation
$api->saveEntities(array($bankAccount, $existingAccount));


```



#### Load an entity
Different from some other API libraries, there's no 'getById' method provided. Instead, you use an empty entity with a given *uid* as the data holder and load the data into the entity using the **loadEntity** method:

```
//Create an empty entity object
$newBankAccount = new BankAccount();

//Set the uid you want to get
$newBankAccount->uid = 23456;

//Load the data for the entity
$api->loadEntity($newBankAccount);

echo $newBankAccount->name; //prints "Updated Name";


```

#### Search Entities ( List Entities )
To search/list entites, you will need to specify the search criterion. This is done by creating a criteria object and setting the properties of that object. Every main entities class has an accompanying criteria class. For example, to search for a *BankAccount*, you will need a *BankAccountCriteria* object. **More details will be covered in later sections.**

```
$criteria = new BankAccountCriteria();
$criteria->isInbuilt = 'false';
$criteria->type = AccountType::Income;
$criteria->isActive = 'true';

//Return an array of matching Bank Accounts
$results = $api->searchEntities($criteria);

foreach($results as $bankAccount){
	//do something with the $bankAccount entity
}

```

The *searchEntityes* method calls the Saasu *list* api. The *Criteria* object as parameter tell the api what to list and what filters apply. If you don't want to filter the result list you can skip setting any property value of the *Criteria* object:

```
//No filter applies, retrieve all bank accounts
$results = $api->searchEntities(new BankAccountCriteria());

```





When searching entities, the Saasu API actually returns extra fields of data that are not defined as entity object properties. For example, when searching for InvoicePayment, the API returns the *amount* field that is not defined as a property of the InvoicePayment object ( it has InvoicePaymentItems that add up to the total instead). These extra data fields are exposed via the *getExtra* method:

```
$criteria = new InvoicePaymentCriteria();
$criteria->transactionType= TransactionType::SalePayment;
$criteria->bankAccountUid = 23456;

$results = $this->api->searchEntities($criteria);

$result = reset($results);//get the first one;

echo $res->getExtra('amount');//prints 60


```

*** Note: ***

From Oct 2013, the inventoryItemList and commboItemList api will be officially dropped.
Since 1.0.1, this *Saasu PHP Client* uses the new FullInventoryItemList and FullCommboItemList API. Please make sure you have the right version after Oct. 2013.




#### Delete Entity

To delete an entity, you use the *deleteEntity* method. Unlike, updating and inserting entities, there's no bulk action method available to delete multiple entities in one requests. Like the method *loadEntity*, you can use an empty entity object with only the uid to tell the **Saasu PHP Client** what you are deleting.

```
//create a empty entity with a given uid
$toBeDeleted = new BankAccount(23456);

//delete it
$api->deleteEntity($toBeDeleted);

```
Note that the first line of code above passes the uid into the entity constructor. This is a handy optional way to set a *uid* to a newly created object. All main entity classes accept a uid as an optional parameter to their constructors.




## 4. Entities

In **Saasu PHP Client**, the entity objects are what we called Data Transfer Objects. Some entities, like *EmailMessage*, are assisting entities and do not have *uid* property value assigned. Entities that can have assigned *uid* are **main** entities. Only **main** entities have accompanying criteria classes with the exception of *DeletedEntity* and *Tag* (covered later).

#### Main entities

Main Entity Class | Criteria Class
------------ | -------------
Activity | ActivityCriteria
BankAccount | BankAccountCriteria
Contact | ContactCriteria
ComboItem | FullComboCriteria
InventoryItem | FullInventoryItemCriteria
InventoryAdjustment | InventoryAdjustmentCriteria
InventoryTransfer  | InventoryTransferCriteria
Invoice  |  InvoiceCritera
InvoicePayment  | InvoicePaymentCriteria
Journal  | JournalCriteria
TransactionCategory  | TransactionCategoryCriteria


#### Weak entities

There are some entities that are not main entity but are used by a main entity as propery:

Weak Entity Class | Used by Main Entity Class
------------ | -------------
ComboItemItem | ComboItem
EmailMessage | Invoice
InventoryAdjustmentItem  | InventoryAdjustment
InventoryTransferItem  | InventorTransfer
InvoicePaymentItem  | InvoicePayment
JournalItem  | Journal
QuickPayment | Invoice
ServiceInvoiceItem | Invoice
ItemInvoiceItem | Invoice
TradingTerms | Invoice, Contact

You don't create or delete weak entities, instead, you work with weak entities by assigning them to  main entities as properties.

#### Special entities
*Tag* and *DeletedEntity* are special in that they are not actually entities by definition but technically they are DTO objects used mainly for searching purpose. That means, it is a nosense to 'Create' a *DeletedEntity* ( you delete an entity instead) or to 'Create' a *Tag* ( you attach words to a entity as 'tag's).

Entity Class | Criteria Class  | Usage
------------ | -------------    | ----------
DeletedEntity | DeletedEntityCriteria  | Used to search for deleted entities
Tag | TagCriteria | List all tags used or search entities by tags


#### Action entities
These two types of entities are very special in that they are not entity at all but representation of actions you would like the Saasu API to take.


Class | Usage
------------ | ------------
EmailPdfInvoice | To send a Pdf invoice to a contact
BuildComboItem  | To build ComboItems (from InventoryItems)


You can only create these two entities (i.e. create the tasks). No other actions can be done with them. It make no sense to update or delete an EmailPdfInvoice.


#### Helper entity
There is one helper entity that is not technically an entity but it is grouped into the entity category:

Class | Usage
------------ | ------------
InvoiceInstruction | To perform extra task upon inserting/updating an invoice (i.e. send email)

Here is the example if you want to send an email to the contact upon the creation of a new invoice:

```
//prepare an email;
$email = new EmailMessage();
$email->to = "test@hotmail.com";
$email->from = "test.sender@gmail.com";
$email->subject = "test saasu";
$email->body = "test body";

//create an instruction
$instruction = new InvoiceInstruction();
$instruction->emailMessage = $email;
$instruction->emailToContact = 'true';

//create an invoice;
$invoice = new Invoice();
$invoice->date = DateTime:getDate(time());
...

$this->api->saveEntity($invoice, $instruction);

```

When working with Invoice, the *saveEntity* method support another parameter *$instruction*.

## 5. Helper Classes
To make easy working with the entity classes, there are some useful helper classes available.

#### DateTime
Saasu API only accepts UTC, ISO 8061 format date and date time strings for Date and DateTime fields. This class is designed to help you generate the formatted date and datetime string with ease.

There are two static methods available, both accept numeric timestamp or [date string](http://au1.php.net/manual/en/datetime.formats.php) input that are compatible with *strtotime* function

```
echo DateTime::getDate(time());
//2013-07-30

echo DateTime::getDateTimes(time());
//2013-07-30T01:16:53

echo DateTime::getDate('+1day');
//2013-07-31

echo DateTime::getDateTimes('+1day');
//2013-07-31T01:16:53

```
#### Enumeration Classes

Saasu use string tokens as required propery values in many cases. To help avoid typos and make it easy to lookup values, **Saasu PHP Client** make available constants grouped by classes with meaningful names. One can easily work out where they fit by inspecting the class names:


* AccountType
* ActivityAttachedToType
* ContactCategoryType
* EmailFormat
* EntityTypeUID
* IntervalType
* InvoiceLayout
* InvoiceQueryOption
* InvoiceStatus
* InvoiceTypeAU
* InvoiceTypeNZ
* InvoiceTypeSG
* InvoiceTypeOther
* JournalItemType
* PaiStatus
* Salutation
* SearchFieldName
* TaxCode
* TradingTermsType
* TransactionType

Enumeration classes extends the *EnumBase* class which provides two useful static methods *keys()* and *values()*:

##### keys()
Returns an array of constant names of the class

##### values()
Return an associate array with constant names as keys and their values as values



## 6. Exceptions

When *Saasu API* rejects the request, an exception is thrown with the relevant message and response code. There is a lot to take care when dealing with some complicated entities such as Invoice where inventory/stock level, account balance and payments must keep consistent.


Rules for invoices:

* Duplicate invoice number is not allowed.
* Invoice overpayment is not allowed (e.g. Applying $200 payment to $100 invoice is not * permitted).
* Tax code cannot be applied to Tax Accounts (Asset: Tax Paid on Purchases and Liability: Tax Collected from Sales).
* Tax code cannot be applied to Bank Accounts.
* If due date is specified along with trading terms, then trading terms will take precedence
over due date to set the actual due date for the invoice being saved.
* Inserting, updating, and deleting item invoices that have the potential to cause invalid stock level are not permitted.

Sometimes it is just too easy to create, update, or delete an invoice that results in breaking these rules. In those cases, exception is to help:

```
try{
	…
	$api->deleteEntity($invoice);
	…
}catch(Exception $e){
	$err = $e->getMessage();
	//report the exception
	echo $err;
}

```




## 7. Unit Tests

The test cases included in this library has 200+ assertion, they can also be served as a collection of examples covering every entity and most usage cases.

Please take time to inspect the test code if necessary.

Running the test cases requires PHPUnit. Also one must update the **TestBase.php** file with his own test account wsaccesskey and fileUID.

```

//file tests/Dlin/Saasu/Tests/Entity/TestBase.php
...
public function setUp()
{
        //Please update with your testing account settings
        $this->api = new SaasuAPI('D4A92597762C4FDCAF66FF03C988B7B0', '41509');
}
```




## 8. Validation

All entities in this **Saasu PHP Client** library also come with a *validate()* method.

The *validate* method returns a Validator instance that provides the *hasError* and *getErrors* method.

The **hasError(fieldName)** method returns true if the given field is invalid, false otherwise

The **getErrors()** method returns an associated array of errors with the keys being field names and the type of error as value;

Let's take a snippet of test case as an example:

```
$a = new Activity();

//If no field name is given, any invalid field will result in **hasError** returning true.
$this->assertTrue($a->validate()->hasError());

//If a field name is given, true is returned if the given field has invalid value
$this->assertTrue($a->validate()->hasError('type'));

//getErrors return all errors if there's any
$errors = $a->validate()->getErrors();

//The error message is just the type of error
echo $error['type']; //prints "required";

//'required' is simple one of many error types, you can look at the Validator class for all.
$a->type="Some invalid value";
$errors = $a->validate()->getErrors();
echo $error['type']; //prints "enum"; i.e invalid value

//Using the classe constants help avoid invalid values
$a->type= ActivityType::Sale;
$this->assertFalse($a->validate()->hasError('type'));

```

Some fields are required only when the entity is being update. For example, the *uid* field is required when you want to update an entity. For this purpose, the **validate** method for main entities accept an optional parameter to indicate the validation is for an 'update' operation.

```
$invoice = new Invoice();

echo $invoice->validate(true)->hasError('uid'); //true for update
echo $invoice->validate()->hasError('uid'); //false for create
```


## 9. Limitation & Known Issues

#### Usage Limit
The Saasu empose some Fair play limits:
>Maximum of 5 requests per second.

>Maximum of 2,000 requests per day.

>All synchronization activities must rely on Last Modified where this is supported in the API.

>If you are making hundreds of requests at once, insert a minimum of 2 seconds delay for every
50 requests.

>When sending a multiple task request limit the number of tasks to a maximum of 50.


This PHP Client library comes with a internal throttle to make sure **no more than 5 requests ** can be made within any second. However, it is the your own responsibility to take care of other usage limits.

#### Hidden rules

There could be be many undocumentated rules due to the complexity of accounting and the api software itself. 

For example, when searching contacts, inactive contacts will never return, i.e. not searchable.

Another example for deleting an InventoryItem. If you find yourself not being able to delete an InventoryItem, you might need to first delete any related InventoryTransfer, InventoryAdjustment and ComboItem in order before you can successfully delete an InventoryItem. Because there's is a chain of dependency from InventoryAdjustment to InventoryItem. 





## 10. License


This library is free. Please refer to the license file in the root directory for detail license info.

