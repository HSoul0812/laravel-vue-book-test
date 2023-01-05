<?php

namespace App\Http\Controllers;
use App\Models\Library;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    protected $model;

    public function __construct(Library $library)
    {
        $this->model = $library;
    }

    public function index()
    {
        $items = $this->model->with('books')->get();
        return response(['libraries' => $items, 'status' => 200]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'address' => 'required',
            'books' => 'array',
            'books.*' => 'exists:books,id',
        ]);

        $item = $this->model->create($request->all());
        $books = $request->get('books');
        $item->books()->sync($books);
        return $this->index();
    }

    public function destroy($id)
    {
        try {
            $item = $this->model->with('books')->findOrFail($id);
            $item->books()->detach();
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
            return response(['libraries' => $items, 'status' => 200]);
        } catch (ModelNotFoundException $e) {
            return response(['message' => 'Item Not Found!', 'status' => 404]);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|min:3',
                'address' => 'required',
                'books' => 'array',
                'books.*' => 'exists:books,id',
            ]);
            $item = $this->model->with('books')->FindOrFail($id);
            $item->update($request->all());
            $books = $request->get('books');
            $item->books()->sync($books);
            return response(['libraries' => $item, 'status' => 200]);
        } catch (ModelNotFoundException $e) {
            return response(['message' => 'Item Not Found!', 'status' => 404]);
        }
    }
}