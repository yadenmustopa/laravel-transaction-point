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
```

### Route

1. Because in this case I use inertia for integration into the Front end UI, so the route definition is in web.php.

>**_NOTES_**: Biasanya definisi route di file api.php ,, dan menggunakan JWT token for manage auth.

2. Use Group and Bind Method name
```
Route::group(['prefix' => 'customers', 'as' => 'customer.'], function () {
    Route::get('/', [CustomerController::class, 'index'])->name('list');
    Route::post('/', [CustomerController::class, 'store'])->name('store');
});

Route::group(['prefix' => 'transactions', 'as' => 'transaction.'], function () {
    Route::get('/', [TransactionController::class, 'index'])->name('list');
    Route::post('/', [TransactionController::class, 'store'])->name('store');
});
```

to be easier to manage and tidier,,
> for additional information :
 the bind method name is usually used more when interacting with the blade when using the form property action tag using (<form action={{route('name.name')}}>) is useful when there is a change of route endpoint in the future does not change the action value. 

> **_NOTES** : make sure for route route end point creation must be consistent

### Controller
1. Customer 
    
    1.1 List 

    For handle Menu 1 and Menu 3
    ```
      /**
     * Summary of index
     * @param \App\Http\Requests\ListCustomerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $customers = $this->customerRepo->list();
            return ApiResponse::success(__('list.success'), PaginationListResource::make($customers)->setResourceItem(CustomerResource::class));
        } catch (\Exception $e) {
            return ApiResponse::error(__('list.error'), ['general' => $e->getMessage()]);
        }
    }
    ```
    A. Repository Pattern

    I use the repository pattern when interacting with the database,

        the goal is 
        1. To make it easy to maintain
        2. Neater in the controller
        3. When one day you have to use the query builder, just change it in the repository file.

    Look CustomerRepository File :
    ```
    class CustomerRepository extends BaseRepository
    {
        public function __construct(Customer $customer)
        {
            $this->model = $customer;
        }

        public function list($perPage = 10)
        {
            $baseQuery = $this->query()->with([
                'transactions'
            ]);


            $query = QueryBuilder::for ($baseQuery)->allowedFilters([
            ])
                ->defaultSort('-created_at', '-updated_at')
                ->allowedSorts('created_at', 'updated_at', 'name');
            return $query->paginate($perPage)->appends(request()->query());
        }
    }
    ``` 

    CustomerRepository mempunyai parent BaseRepository  karena isi dari base repository adalah fungsi dasar yang banyak di butuhkan

    Look at BaseRepository:
    ```
    app/Repositories/BaseRepository.php
    ```

    >when CustomerRepository is called for the first time, it will inject the Model File, namely Customer in Folder Model, 
    this process is called **Dependency Injection**,
    after that the model is assigned to the model property in the BaseRepository File.

    B. Use 


