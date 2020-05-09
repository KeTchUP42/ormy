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
    $obj = $ormy->getMeneger()->fillRepository(Tables\main::class);
    $obj->setText('Hello World!');
   
    $ormy->getMeneger()->flush();
    $ormy->getMeneger()->flush_and_clean();
#### This code sends insert query 2 times to table main and cleans meneger repository.
#### Example:    
     $obj = $ormy->getMeneger()->fillRepository(Tables\main::class);
     $obj->setText('Hello World!');
     echo $ormy->getMeneger()->build()->getSQL();
##### Output:
   
    INSERT INTO `dev`.`main`(`text`) VALUES ('Hello World!');
#### NOTICE:
    Entity class don't need to have getters only setters to configure.

### Connector:
    $ormy->getConnector();
    
    Class is PDO wrap and has base functional to work with DB.
    If you want to see class functional check IConnector interface.
