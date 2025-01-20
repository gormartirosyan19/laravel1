<?php
namespace App\Services;

use App\Models\Post;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function createPost($validatedData, $request)
    {
        $imageUrl = null;

        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imageUrl = 'post_pictures/' . $imageName;
            $image->move(public_path('storage/post_pictures'), $imageName);
        }

        $post = Post::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'image_url' => $imageUrl,
            'user_id' => Auth::id(),
        ]);

        Activity::create([
            'user_id' => Auth::id(),
            'activity_type' => 'post_created',
            'activity_details' => 'created a new post titled: ' . $validatedData['title'],
        ]);

        return $post;
    }

    public function updatePost($post, $validatedData, $request)
    {
        $post->title = $validatedData['title'];
        $post->content = $validatedData['content'];

        if ($request->hasFile('image_url')) {
            if ($post->image_url) {
                $oldFilePath = public_path($post->image_url);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $image = $request->file('image_url');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'storage/post_pictures/' . $imageName;
            $image->move(public_path('storage/post_pictures'), $imageName);

            $post->image_url = $imagePath;
        }

        $post->save();

        Activity::create([
            'user_id' => Auth::id(),
            'activity_type' => 'post_updated',
            'activity_details' => 'updated the post titled: ' . $validatedData['title'],
        ]);

        return $post;
    }

    public function deletePost($post)
    {
        if ($post->image_url) {
            $oldFilePath = public_path($post->image_url);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        $post->delete();

        Activity::create([
            'user_id' => Auth::id(),
            'activity_type' => 'post_deleted',
            'activity_details' => 'deleted the post titled: ' . $post->title,
        ]);
    }
}
