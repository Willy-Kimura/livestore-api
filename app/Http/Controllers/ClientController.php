<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function index()
    {
        return response(
            [
                'status' => 'Success',
                'message' => 'Records retrieved successfully.',
                'data' => Client::all()
            ],
            200
        );
    }

    public function show(string $id)
    {
        $record = Client::find($id);

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
        $response = Client::create($request->all());

        if ($response->successful()) {
            return response(
                [
                    'status' => 'Success',
                    'message' => 'Record(s) retrieved successfully.',
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
        $record = Client::find($id);

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
        $record = Client::find($id);

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

    public function getPhone(Request $request)
    {
        $data = Client::where('phone_sha256', $request->phone_hash)->first();

        if ($data) {
            return response(
                [
                    'status' => 'Success',
                    'message' => 'Phone number found successfully.',
                    'data' => $data->phone
                ],
                200
            );
        } else {
            return response(
                [
                    'status' => 'Error',
                    'message' => 'Phone number not found.',
                    'data' => null
                ],
                404
            );
        }
    }
}
