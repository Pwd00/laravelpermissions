<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $articles = Articles::orderBy('created_at', direction: 'asc')->paginate(1);
        return view('articles.index', compact('articles'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator::make($request->all(), [
            'title' => 'required|min:3|string',
            'text' => 'required|string|min:8',
            'author' => 'required|min:2|string'
        ]);
        if ($validator->fails()) {
            return redirect()->route('articles.create')->withInput()->withErrors($validator);
        } else {
            Articles::create($validator->validated());
            return redirect()->route('articles.create')->with('success', 'ARTICLES INSERTED SUCCESSFULLY 😊🏝️');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Articles::findOrFail($id);
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $article = Articles::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:2|string',
            'text' => 'required|string|min:8',
            'author' => 'required|string|min:2'
        ]);
        if ($validator->fails()) {
            return redirect()->route('articles.edit')->withInput()->withErrors($validator);
        } else {
            $article->title = $request->input('title');
            $article->text = $request->input('text');
            $article->author = $request->input('author');
            $article->save();
            return redirect()->route('articles.edit', $id)->with('Success', 'Articles Updated SucessFully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
