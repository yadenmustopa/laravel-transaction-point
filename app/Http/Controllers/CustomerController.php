<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListCustomerRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\PaginationListResource;
use App\Libraries\ApiResponse;
use App\Models\Customer;
use App\Repositories\CustomerRepository;

class CustomerController extends Controller
{

    protected $customerRepo;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepo = $customerRepository;
    }

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

    /**
     * Show the form for creating a new resource.
     */
    public function create(StoreCustomerRequest $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        try {
            $createdCustomer = $this->customerRepo->create($request->validated());
            return ApiResponse::success(_('store.success'), new CustomerResource($this->customerRepo->getOneByIdOrFail($createdCustomer->id)));
        } catch (\Exception $e) {
            return ApiResponse::error(__('store.error'), ['general' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        try {

        } catch (\Exception $e) {

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}