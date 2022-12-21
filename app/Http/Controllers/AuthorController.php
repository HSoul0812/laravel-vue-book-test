<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    protected $model;

    public function __construct(Author $author)
    {
        $this->model = $author;
    }

    public function index()
    {
        $items = $this->model->with('books')->get();
        return response(['authors' => $items, 'status' => 200]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'birthday' => 'required|date_format:Y-m-d',
            'genre' => 'required',
        ]);
        $data = $request->all();
        $this->model->create($data);
        return $this->index();
    }

    public function destroy($id)
    {
        try {
            $item = $this->model->with('books')->findOrFail($id);
            $item->delete();
            return $this->index();
        } catch (ModelNotFoundException $e) {
            return response(['message' => 'Item Not Found!', 'status' => 404]);
        }
    }

    public function show($id)
    {
        try {
            $item = $this->model->with('books')->findOrFail($id);
            return response(['authors' => $item, 'status' => 200]);
        } catch (ModelNotFoundException $e) {
            return response(['message' => 'Item Not Found!', 'status' => 404]);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $item = $this->model->with('books')->FindOrFail($id);
            $item->update($request->all());
            return response(['authors' => $item, 'status' => 200]);
        } catch (ModelNotFoundException $e) {
            return response(['message' => 'Item Not Found!', 'status' => 404]);
        }
    }
}