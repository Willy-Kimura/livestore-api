<?php

namespace App\Http\Controllers;

use App\Models\BrandCategory;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use stdClass;

class BrandCategoryController extends Controller
{
    private $content = array();

    public function populate()
    {
        $path = app_path() . '\data\brand-categories-official.csv';

        $csv = array_map(function ($ln) {
            $row = explode(',', preg_replace('~[\r\n]+~', '', $ln));

            $b = Brand::where('name', $row[0])->first();
            $c = Category::where('name', $row[1])->first();

            if (array_key_exists($row[0], $this->content)) {
                array_push($this->content[$row[0]], $row[1]);
            } else {
                $this->content += [$row[0] => [$row[1]]];
            }

            BrandCategory::create([
                'brand_id' => $b->id,
                'category_id' => $c->id
            ]);
        }, file($path));

        return response(
            [
                'status' => 200,
                'message' => count($this->content) . ' records found successfully.',
                'data' => $this->content
            ]
        );
    }

    public function index()
    {
        $query = Brand::with(['categories' => function ($query) {
                    $query->select('id', 'brand_id', 'category_id');
                }])->get(['id', 'name']);

        $coll = array();

        foreach ($query as $record) {
            $cats = $record['categories'];
            $obj = (object)[];

            $obj->id = $record['id'];
            $obj->name = $record['name'];
            $obj->categories = array();

            foreach ($cats as $cat) {
                array_push($obj->categories, Category::find($cat->category_id, ['id', 'name']));
            }

            array_push($coll, $obj);
        }

        return response(
            [
                'status' => 'Success',
                'message' => 'Records retrieved successfully.',
                'data' => $coll
            ],
            200
        );
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
}
