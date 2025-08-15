<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderProduct;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        return response(
            [
                'status' => 'Success',
                'message' => 'Records retrieved successfully.',
                'data' => Order::all()
            ],
            200
        );
    }

    public function show(string $id)
    {
        $record = Order::find($id);

        if ($record) {
            return response(
                [
                    'status' => 'Success',
                    'message' => 'Records retrieved successfully.',
                    'data' => $record
                ],
                200
            );
        } else {
            return response(
                [
                    'status' => 'Not found',
                    'message' => 'Record was not found.',
                    'data' => null
                ],
                404
            );
        }
    }

    public function store(Request $request)
    {
        $record = Order::where('order_no', $request->order_no)->first();

        if ($record) {
            return response(
                [
                    'status' => 'Error',
                    'message' => 'An order with the same order number already exists.',
                    'data' => $record
                ],
                400
            );
        } else {
            $response = Order::create($request->all());

            if ($response->wasRecentlyCreated) {
                return response(
                    [
                        'status' => 'Success',
                        'message' => 'Record created successfully.',
                        'data' => $response
                    ],
                    200
                );
            } else {
                return response(
                    [
                        'status' => 'Error',
                        'message' => 'Record was not created.',
                        'data' => null
                    ],
                    400
                );
            }
        }
    }

    public function addOrderProduct(Request $request)
    {
        $response = OrderProduct::create($request->all());

        if ($response->wasRecentlyCreated) {
            return response(
                [
                    'status' => 'Success',
                    'message' => 'Record created successfully.',
                    'data' => $response
                ],
                200
            );
        } else {
            return response(
                [
                    'status' => 'Error',
                    'message' => 'Record was not created.',
                    'data' => null
                ],
                400
            );
        }
    }

    public function update(string $id, Request $request)
    {
        $record = Order::find($id);

        if ($record) {
            $updated = $record->update($request->all());

            if ($updated) {
                return response(
                    [
                        'status' => 'Success',
                        'message' => 'Record updated successfully.',
                        'data' => $request
                    ],
                    200
                );
            } else {
                return response(
                    [
                        'status' => 'Error',
                        'message' => 'Record not updated.',
                        'data' => null
                    ],
                    400
                );
            }
        } else {
            return response(
                [
                    'status' => 'Not found',
                    'message' => 'Record was not found.',
                    'data' => null
                ],
                404
            );
        }
    }

    public function destroy(string $id)
    {
        $record = Order::find($id);

        if ($record) {
            $result = $record::delete();

            if ($result) {
                return response(
                    [
                        'status' => 'Success',
                        'message' => 'Record deleted successfully.',
                        'data' => $record
                    ],
                    200
                );
            } else {
                return response(
                    [
                        'status' => 'Error',
                        'message' => 'Record not deleted.',
                        'data' => null
                    ],
                    400
                );
            }
        } else {
            return response(
                [
                    'status' => 'Not found',
                    'message' => 'Record was not found.',
                    'data' => null
                ],
                404
            );
        }
    }
}
