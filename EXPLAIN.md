ِبِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيْم
# EXPLAIN

## INTRODUCTION
### IMPROVEMENT
1. For column id naming in migration, I use type uuid for security and other reasons.
```
 $table->uuid("id")->primary();
 ```
 2. for consistency issues and the reason that there are time zone differences for each user then: 
 >by default in laravel for date time data types it uses the UTC zone, and it should be so.
so as not to be confused when responding or sending date time filters that use unixe timestamp ms.

**_NOTES_** :for that I casts for the transaction date so that when the response becomes epoch, and vice versa when the input also uses epoch unix timestamp.

### support function
1. Exception Handler

I registered a custom exception in file for consistency in exception response.

Look at File : 
```
app/Exceptions/Handler.php
```

2. Library Api Response

To make it easier to manage api responses, I created a library to make it easier to manage responses and code.

Look at File 
: 
```
app/Libraries/ApiResponse.php
