<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\BrandCategory;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        return response(
            [
                'status' => 'Success',
                'message' => 'Records retrieved successfully.',
                'data' => Brand::all()
            ],
            200
        );
    }

    public function getProducts(string $name)
    {
        $query = Product::join('brands', 'brands.id', 'products.brand_id')
            ->where('brands.name', $name)
            ->get();

        if (count($query) > 0) {
            return response(
                [
                    'status' => 'Success',
                    'message' => 'Records retrieved successfully.',
                    'data' => $query
                ],
                200
            );
        } else {
            return response(
                [
                    'status' => 'Not found',
                    'message' => 'Records were not found.',
                    'data' => null
                ],
                404
            );
        }
    }

    public function getCategories(string $name)
    {
        $query = Brand::join('brand_categories', 'brand_categories.brand_id', 'brands.id')
            ->join('categories', 'categories.id', 'brand_categories.category_id')
            ->where('brands.name', $name)
            ->get();

        if (count($query) > 0) {
            return response(
                [
                    'status' => 'Success',
                    'message' => 'Records retrieved successfully.',
                    'data' => $query
                ],
                200
            );
        } else {
            return response(
                [
                    'status' => 'Not found',
                    'message' => 'Records were not found.',
                    'data' => null
                ],
                404
            );
        }
    }

    public function getProductsAndCategories(string $name)
    {
        $query = Brand::with(['categories'])->paginate(10);

        foreach ($query as $bc) {
            $cats = $bc->categories;

            foreach ($cats as $cat) {
                $cat->products = array();
                $cat->products = Product::where('category_id', $cat->category_id)->get();
            }
        }

        if (count($query) > 0) {
            return response(
                [
                    'status' => 'Success',
                    'message' => 'Records retrieved successfully.',
                    'data' => $query
                ],
                200
            );
        } else {
            return response(
                [
                    'status' => 'Not found',
                    'message' => 'Records were not found.',
                    'data' => null
                ],
                404
            );
        }
    }
    public function getAllProductsByBrands()
    {
        $query = Brand::with(['products'])->get();

        if (count($query) > 0) {
            return response(
                [
                    'status' => 'Success',
                    'message' => 'Records retrieved successfully.',
                    'data' => $query
                ],
                200
            );
        } else {
            return response(
                [
                    'status' => 'Not found',
                    'message' => 'Records were not found.',
                    'data' => null
                ],
                404
            );
        }
    }

    public function show(string $id)
    {
        $record = Brand::find($id);

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

    public function search(string $name)
    {
        $record = Brand::where('name', $name)
            ->first(['id', 'name', 'country', 'homepage', 'description', 'logo']);

        if ($record) {
            return response(
                [
                    'status' => 'Success',
                    'message' => 'Record retrieved successfully.',
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
        $response = Brand::create($request->all());

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
        $record = Brand::find($id);

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

    public function destroy($id)
    {
        $record = Brand::find($id);

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
