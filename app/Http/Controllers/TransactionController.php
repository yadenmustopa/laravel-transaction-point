<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListTransactionRequest;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Http\Resources\PaginationListResource;
use App\Http\Resources\TransactionResource;
use App\Libraries\ApiResponse;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Exception;

class TransactionController extends Controller
{
    protected $transactionRepo;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepo = $transactionRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ListTransactionRequest $request)
    {
        try {
            $transactions = $this->transactionRepo->list();

            return ApiResponse::success(
                __('list.success'),
                PaginationListResource::make($transactions)->setResourceItem(TransactionResource::class)
            );
        } catch (Exception $exception) {
            return ApiResponse::error(__('list.error'), ['general' => $exception->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        try {
            $createdTransaction = $this->transactionRepo->create($request->validated());
            return ApiResponse::success(_('store.success'), new TransactionResource($this->transactionRepo->getOneByIdOrFail($createdTransaction->id)));
        } catch (Exception $e) {
            return ApiResponse::error(__('member.store.error'), ['general' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}