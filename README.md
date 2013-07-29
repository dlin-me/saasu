# Saasu API PHP Client


## 1. Overview

This is a PHP Client library for [**Saasu**](http://www.saasu.com), the online accounting software. Full API documentation is available at <http://help.saasu.com/api/>

This library is designed to make it easy to work with the  Saasu API for general purpose. 

## 2. Usage
This library, hereafter refered to as **Saasu PHP Client**, comes with a very simple interface with methods for interacting with Saasu API to load, insert, update, search, and delete entities.

#### Instantiate the main api instance 

```
$wsaccesskey = 'D4A92597762C4FDCAF66FF03C988B7B2';
$fileUid = '41555';
//Instantiate the main class for later use
$api = new SaasuAPI($wsaccesskey, $fileUid);
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

The *save()* method takes an entity object (See bellow for more details) and persists  object properties. The *save()* method works out if a 'create' operation or 'update' operation by inspecting the *uid* property of the entity object. If the entity object have a *null* *uid* property, a new entity will be created. If the entity object have a numeric *uid* property, which indicates an existing entity object, the existing entity object will be updated.

#### Update an entity
```
//change some value of an existing entity with a uid
echo $bankAccount->uid; //prints 23456, 
$bankAccount->name = "Updated Name";

//Save the change 
$api->saveEntity($bankAccount);
```


#### Updating and Inserting entities in bulk
The **Saasu PHP Client** allows updating and inserting multiple entities in one request. This is supported by the *saveEntities* method, which takes an array of entity objects to update or insert. You can mix existing entities and new entities into one array and perform the update and create actions at the same time in one single request.

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

#### Search Entities
To search entites, you will need to specify the search criterion. This is done by creating a criteria object and setting the properties of that object. Every main entities class has an accompanying criteria class. For example, to search for a *BankAccount*, you will need a *BankAccountCriteria* object. **More details will be covered in later sections.**

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

When searching entities, the Saasu API actually returns extra fields of data that are not defined as entity object properties. For example, when searching for InvoicePayment, the API returns the *amount* field that is not defined as a property of the InvoicePayment object ( it has InvoicePaymentItems that add up to the total instead). These extra data fields are exposed via the *getExtra* method:

```
$criteria = new InvoicePaymentCriteria();
$criteria->transactionType= TransactionType::SalePayment;
$criteria->bankAccountUid = 23456;

$results = $this->api->searchEntities($criteria);

$result = reset($results);//get the first one;

echo $res->getExtra('amount');//prints 60


```





#### Delete Entity

To delete an entity, you use the *deleteEntity* method. Unlike, updating and inserting entities, there's no bulk action method available to delete multiple entities in one requests. Like the method *loadEntity*, you can use an empty entity object with only the uid to tell the **Saasu PHP Client** what you are deleting.

```
//create a empty entity with a given uid
$toBeDeleted = new BankAccount(23456);

//delete it
$api->deleteEntity($toBeDeleted);

```
Note that theh first line of code above passes the uid into the entity constructor. This is a handy optional way to set a *uid* to a newly created object. All main entity classes accept a uid as an optional parameter to their constructors.




## 3. Entities

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

You don't create or delete weak entities by themselves. Instead, you work with weak entities by assigning them to  main entities as properties.

#### Special entities
*Tag* and *DeletedEntity* are special in that they are not actually entities in definition but technically they are DTO objects used mainly for searching purpose. That means, it is nosense to 'Create' a *DeletedEntity* (you delete an entity instead) or to 'Create' a *Tag* (you attach words to a entity as 'tag's). 

Entity Class | Criteria Class  | Usage 
------------ | -------------    | ----------
DeletedEntity | DeletedEntityCriteria  | Used to search for deleted entities
BankAccount | BankAccountCriteria | List all tags used or search entities by tags


#### Action entities
These two types of entities are very special in that they are not entity at all but representation of actions you would like the Saasu API to do.


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
//prepare a email;
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

## 4. Helper Classes
To make easy working with the entity classes, there are some useful helper classes available.

#### DateTime 
Saasu API only accepts UTC, ISO 8061 format date and date time strings for Date and DateTime fields. This class is designed to help you generate the formatted date and datetime string with ease.

There are two static methods available, both accept numeric timestamp or [date string](http://au1.php.net/manual/en/datetime.formats.php) input that are compactible with *strtotime* function

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

Saasu use string tokens as required propery values in many cases. To help avoid typos and make it easy to lookup values, **Saasu PHP Client** make available constants grouped by classes with meaningful name. One can easily workout where they fit by inspecting the class names:


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



## 4. Unit Tests

The test cases included in this library can also be served as a collection of examples covering every entity and most usage cases.

Please take time to inspect the test code if necessary.



## 5. Exceptions



## 6. Validation



## 5. Limitation & Known Issues

#### Usage Limit
The Saasu empose some Fair play limits:
>Maximum of 5 requests per second.
Maximum of 2,000 requests per day.
All synchronization activities must rely on Last Modified where this is supported in the API.
If you are making hundreds of requests at once, insert a minimum of 2 seconds delay for every 50 requests.
When sending a multiple task request limit the number of tasks to a maximum of 50.


This PHP Client library comes with a internal throttle to make sure no more than 5 requests can be made within any second. However, it is the user's responsibility to take care of other usage limits.




## 6. License


