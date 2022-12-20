<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $model;

    public function __construct(Book $book)
    {
        $this->model = $book;
    }

    public function index()
    {
        $items = $this->model->with('libraries', 'author')->get();
        return response(['books' => $items, 'status' => 200]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'year' => 'required|integer|digits:4',
            'author_id' => 'exists:authors,id',
            'libraries' => 'array',
            'libraries.*' => 'exists:libraries,id',
        ]);
        $item = $this->model->create($request->all());
        $libraries = $request->get('libraries');
        $item->libraries()->sync($libraries);
        return $this->index();
    }

    public function destroy($id)
    {
        try {
            $item = $this->model->with('libraries', 'author')->findOrFail($id);
            $item->libraries()->detach();
            $item->delete();
            return $this->index();
        } catch (ModelNotFoundException $e) {
            return response(['message' => 'Item Not Found!', 'status' => 404]);
        }
    }

    public function show($id)
    {
        try {
            $item = $this->model->with('libraries', 'author')->findOrFail($id);
            return response(['books' => $item, 'status' => 200]);
        } catch (ModelNotFoundException $e) {
            return response(['message' => 'Item Not Found!', 'status' => 404]);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|min:3',
                'year' => 'required|integer|digits:4',
                'author_id' => 'exists:authors,id',
                'libraries' => 'array',
                'libraries.*' => 'exists:libraries,id',
            ]);

            $item = $this->model->with('libraries', 'author')->FindOrFail($id);
            $item->update($request->all());
            $libraries = $request->get('libraries');
            $item->libraries()->sync($libraries);
            return $this->index();
        } catch (ModelNotFoundException $e) {
            return response(['message' => 'Item Not Found!', 'status' => 404]);
        }
    }
}