<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    private function rules(): array
    {
        return [
            'title'   => 'required|string|min:3|max:255',
            'content' => 'required|string|min:10',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    private function messages(): array
    {
        return [
            'title.required'   => 'Judul wajib diisi.',
            'title.min'        => 'Judul minimal 3 karakter.',
            'content.required' => 'Konten wajib diisi.',
            'content.min'      => 'Konten minimal 10 karakter.',
            'image.image'      => 'File harus berupa gambar.',
            'image.max'        => 'Ukuran gambar maksimal 2MB.',
        ];
    }

    // 1. index (+ pencarian + pagination)
    public function index(Request $request)
    {
        $posts = Post::query()
            ->when($request->search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('title', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('posts.index', compact('posts'));
    }

    // 2. create
    public function create()
    {
        return view('posts.create');
    }

    // 3. store
    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), $this->messages());

        try {
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('posts', 'public');
            }
            Post::create($data);

            return redirect()->route('posts.index')
                ->with('success', 'Post berhasil ditambahkan!');
        } catch (\Throwable $e) {
            return back()->withInput()
                ->with('error', 'Gagal menyimpan post: ' . $e->getMessage());
        }
    }

    // 4. show (Route Model Binding)
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    // 5. edit (Route Model Binding)
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    // 6. update (Route Model Binding)
    public function update(Request $request, Post $post)
    {
        $data = $request->validate($this->rules(), $this->messages());

        try {
            if ($request->hasFile('image')) {
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }
                $data['image'] = $request->file('image')->store('posts', 'public');
            }
            $post->update($data);

            return redirect()->route('posts.index')
                ->with('success', 'Post berhasil diperbarui!');
        } catch (\Throwable $e) {
            return back()->withInput()
                ->with('error', 'Gagal memperbarui post: ' . $e->getMessage());
        }
    }

    // 7. destroy (soft delete)
    public function destroy(Post $post)
    {
        try {
            $post->delete();

            return redirect()->route('posts.index')
                ->with('success', 'Post berhasil dihapus!');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus post: ' . $e->getMessage());
        }
    }
}