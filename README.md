StaticData
==========

Staticdata will just replace a SQL server, it uses files with objects to save your data.


#### Why would you use Static data?
Simple, to replace sql. Working on a local machine wit braggy sql support? Just not in the mood the set it up? Or just want an awsome super safe local file stored database? Which works great with PHP Safe's encryption? Then static Data is something for you!!

Now enough with the sales talk, it is a simple set up, the only thing you need is a chmodded file and the class will handle your data problems.
#### Uppoints
 - easy back ups
 - simple set ups
 - dynamic databases with easy extra fields
 - secure
 - no random sql server giberish / no extra servers needed

#### Downpoint
Wel above an x amount of files the system could get kinda slow..

#### Setting up:
include the staticData.php class, and wel yes.. call it: (we are working on building a bigger better and faster version with more valid php, so no composer support yet.)

    require_once('staticData.php');

When you did that well you are nearly ready to go.
Make shure you CHMODDED the class file and the folder you want to store your data sets.
The class does not automaticly create the folder you want to use (yet, i know it's a easy thing but we want to be shure the other things where fixed first).

(so just create the folder: eg: data/static (if you clone this, you will probably have it already)).. make shure it's chmodded (0755+)
Now just call it: and you wil have your object ready.

    $data = new data('static');
You can work with the data set by calling a public function around the given class object.

    $data->getAll();

Will return everything of the data group.

    Array
    (
        [1] => Array
            (
                [id] => 1
                [first-name] => Matti
                [sur-name] => van de Weem
                [age] => 19
                [country] => nl
                [Main language] => PHP
            )

    )

Just check the class file for the rest of the functions ATM (larger readmeh incomming!!)

___
Want it to entirely replace sql? You might want to check:

[This link](https://github.com/search?utf8=%E2%9C%93&q=php+sql+array)


___
Function list:
 - runable  : Check if class is runable
 - newSet   : Create a new data set
 - create   : Create a new data object
 - latestId : Obtain latest inserted id
 - delete   : Delete data object
 - read     : Return single data object by id
 - update   : Update a data object
 - all      : Return all data objects
 - allSets  : Return array of all data sets
 - where    : Returns array of all data objects matching criteria
 - .....

hf ;).

~~ Matti van de Weem .nl
