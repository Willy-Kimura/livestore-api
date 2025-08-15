<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;

class ProductController extends Controller
{
    private $content = array();

    public function populate()
    {
        $path = app_path() . '\data\products-official.csv';
        $file = fopen($path, "r");

        while (!feof($file)) {
            $row = fgetcsv($file);

            if ($row != false) {
                array_push($this->content, $row);

                $brand = Brand::where('name', $row[1])->first();
                $category = Category::where('name', $row[2])->first();

                Product::create([
                    'brand_id' => $brand->id,
                    'category_id' => $category->id,
                    'sku' => $row[3],
                    'name' => $row[0],
                    'short_desc' => str_replace("\"", "", $row[5]),
                    'long_desc' => str_replace("\"", "", $row[5]),
                    'regular_price' => floatval($row[4]),
                    'sale_price' => floatval($row[4]),
                    'status' => 'In Stock',
                    'attribute' => 'Weight',
                    'unit' => 'ml',
                    'rating' => 5,
                    'images' => json_encode([$row[6]]),
                    'tags' => $row[7]
                ]);
            }
        }

        fclose($file);

        return response(
            [
                'status' => 200,
                'message' => count($this->content) . ' records found successfully.',
                'data' => $this->content
            ]
        );
    }

    public function updateProducts()
    {
        $path = app_path() . '\data\products-catalogue-28-07-25-0400.csv';
        $file = fopen($path, "r");

        while (!feof($file)) {
            $row = fgetcsv($file);

            if ($row != false) {
                array_push($this->content, $row);

                $product = Product::where('name', $row[0])->first();

                if ($product) {
                    $product->long_desc = $row[8];
                    $product->save();
                }
            }
        }

        fclose($file);

        return response(
            [
                'status' => 200,
                'message' => count($this->content) . ' records found successfully.',
                'data' => $this->content
            ]
        );
    }

    public function updateBrands()
    {
        $path = app_path() . '\data\brands-official-29-07-25.csv';
        $file = fopen($path, "r");

        while (!feof($file)) {
            $row = fgetcsv($file);

            if ($row != false) {
                array_push($this->content, $row);

                // echo $row[0] . ' - ' . $row[1] . ' - ' . $row[2];

                $brand = Brand::where('name', $row[0])->first();

                if ($brand) {
                    $brand->description = $row[1];
                    $brand->logo = $row[2];
                    $brand->save();
                }
            }
        }

        fclose($file);

        return response(
            [
                'status' => 200,
                'message' => count($this->content) . ' records updated successfully.',
                'data' => $this->content
            ]
        );
    }

    public function index()
    {
        $query = Product::join('brands', 'brands.id', 'products.brand_id')
            ->join('categories', 'categories.id', 'products.category_id')
            ->select('products.*', 'brands.name as brand', 'categories.name as category')
            ->get();

        return response(
            [
                'status' => 'Success',
                'message' => 'Records retrieved successfully.',
                'data' => $query
            ],
            200
        );
    }

    public function show(string $id)
    {
        $record = Product::find($id);

        if ($record) {
            return response(
                [
                    'status' => 'Success',
                    'message' => 'Records retrieved successfully.',
                    'data' => Product::all()
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

    public function search(Request $request)
    {
        $record = Product::join('brands', 'brands.id', 'products.brand_id')
            ->join('categories', 'categories.id', 'products.category_id')
            ->select('products.*', 'brands.name as brand', 'categories.name as category')
            ->where(['products.name' => $request->name])
            ->first();

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
        $response = Product::create($request->all());

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

    public function update($id, Request $request)
    {
        $record = Product::find($id);

        if ($record == null) {
            return response(
                [
                    'status' => 'Not found',
                    'message' => 'Record was not found.',
                    'data' => null
                ],
                404
            );
        } else {
            $updated = $record->update($request->all());

            if ($updated) {
                return response(
                    [
                        'status' => 'success',
                        'message' => 'Record updated successfully.',
                        'data' => $request
                    ],
                    200
                );
            } else {
                return response(
                    [
                        'status' => 'error',
                        'message' => 'Record not updated.',
                        'data' => null
                    ],
                    400
                );
            }
        }
    }

    public function destroy($id)
    {
        $record = Product::find($id);

        if ($record == null) {
            return response(
                [
                    'status' => 'Not found',
                    'message' => 'Record was not found.',
                    'data' => null
                ],
                404
            );
        } else {
            $result = $record::delete();

            if ($result) {
                return response(
                    [
                        'status' => 'success',
                        'message' => 'Record deleted successfully.',
                        'data' => $record
                    ],
                    200
                );
            } else {
                return response(
                    [
                        'status' => 'error',
                        'message' => 'Record not deleted.',
                        'data' => null
                    ],
                    400
                );
            }
        }
    }
}
