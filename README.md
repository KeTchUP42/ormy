# ORMY

My little realization of simple orm just for fun.

## How to use:

### Migrator:
    $ormy = new Ormy('mysql:dbname=dev;host=localhost', 'root', 'roma', __DIR__.'/Migrations',null);
    
    $sqlQueryUp = "CREATE TABLE `dev`.`main`...;"
    $sqlQueryDown =  "DROP TABLE `dev`.`main`;"   
    
    $ormy->getMigrator()->makeMigration($sqlQueryUp,$sqlQueryDown);
    $ormy->getMigrator()->migrateUp();   
#### So, you have made new migration and put it to `__DIR__.'/Migrations'` with auto generated namespace 'Migrations'.
#### Then you called 'up' method in it.

    $ormy->getMigrator()->migrateDown();
#### You have called 'down' method in all executed migration and cleaned 'migration version' table in your DB.

### Meneger:            

    $entity = $ormy->getMeneger()->getRepository(Entity\main::class);
    $entity->setText('Hello World!');
    $ormy->getMeneger()->flush($entity);
    $ormy->getMeneger()->flush($entity);
#### This code sends insert query 2 times to table main.
#### Example:    
   
     $entity = $ormy->getMeneger()->getRepository(Entity\main::class);
     $entity->setText('Hello World!');
     echo $ormy->getMeneger()->build($entity)->getSQL();
##### Output:
   
    INSERT INTO `dev`.`main`(`text`) VALUES ('Hello World!');
#### NOTICE:

    Entity class don't need to have getters only setters to configure. 
    Meneger gets your entity fields as table columns. Example: private string $text => `text`
### Connector:
    $ormy->getConnector();
    
    Class is PDO wrap and has base functional to work with DB.
    If you want to see class functional check IConnector interface.
