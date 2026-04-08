<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome', [
    'greeting' => 'Hello, World!',
    'name' => 'John Doe',
    'age' => 30,
    'tasks' => [
        'Learn Laravel',
        'Build a project',
        'Deploy to production',
    ],
]);

Route::view('/about', 'about');
Route::view('/contact', 'contact');

Route::get('/formtest', function () {
    $posts = Post::all();

    return view('formtest', [
        'posts' => $posts,
    ]);
});

Route::post('/formtest', function () {
    Post::create([
        'description' => request('description'),
    ]);

    return redirect('/formtest');
});

Route::delete('/formtest/{id}', function ($id) {
    Post::findOrFail($id)->delete();

    return redirect('/formtest');
});

Route::get('/delete', function () {
    Post::truncate();

    return redirect('/formtest');
});

Route::get('/posts', function () {
    $posts = Post::all();

    return view('posts.index', [
        'posts' => $posts,
    ]);
});

Route::get('/posts/{post}', function (Post $post) {
    return view('posts.show', [
        'post' => $post,
    ]);
});

Route::get('/posts/{post}/edit', function (Post $post) {
    return view('posts.edit', [
        'post' => $post,
    ]);
});

Route::patch('/posts/{post}', function (Post $post) {
    $post->update([
        'description' => request('description'),
        'updated_at' => now(),
    ]);

    return redirect('/posts/' . $post->id);
});



// User Registration and Management Routes
Route::get('/user_registration', function () {
    $users = User::orderBy('created_at', 'desc')->get();

    return view('user_registration', [
        'users' => $users,
        'editingUser' => null,
    ]);
});

Route::post('/user_registration', function (Request $request) {
    $data = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'nickname' => 'nullable|string|max:255',
        'email' => 'required|email|unique:users,email',
        'age' => 'nullable|integer|min:0|max:150',
        'address' => 'nullable|string|max:500',
        'contact_number' => 'nullable|string|max:50',
    ]);

    User::create($data);

    return redirect('/user_registration')->with('success', 'User registered successfully.');
});

Route::get('/users/{user}/edit', function (User $user) {
    $users = User::orderBy('created_at', 'desc')->get();

    return view('user_registration', [
        'users' => $users,
        'editingUser' => $user,
    ]);
});

Route::put('/users/{user}', function (Request $request, User $user) {
    $data = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'nickname' => 'nullable|string|max:255',
        'email' => ['required','email', 'unique:users,email,' . $user->id],
        'age' => 'nullable|integer|min:0|max:150',
        'address' => 'nullable|string|max:500',
        'contact_number' => 'nullable|string|max:50',
    ]);

    $user->update($data);

    return redirect('/user_registration')->with('success', 'User updated successfully.');
});

Route::delete('/users/{user}', function (User $user) {
    $user->delete();

    return redirect('/user_registration')->with('success', 'User deleted successfully.');
});

