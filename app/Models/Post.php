<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
class Post extends Model
{
    use HasFactory, Searchable;


   /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return 'posts_index';
    }
    //one to many (inverse)- user has many posts
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    //one to many (inverse)- post has one 
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    //one to many (inverse)- post has many tags
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
    
    /* protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query->with(['user','category','tags']);
    } */

    /* public function toSearchableArray()
    {
        return [
            'title' => '',
            'content' => '',
            'categories.name' => '',
            'tags.name' => '',
            'users.name' => '',
            'publish_date' => '',
        ];
    } */

    // public function toSearchableArray()
    // {
    //     $array = $this->toArray();

    //     //$array = $this->transform($array);

    //     $array['category_name'] = $this->category->name;
    //     $array['user_name'] = $this->user->name;
    //     $array['tag'] = $this->tags->map(function ($data) {
    //         return $data['name'];
    //     })->toArray();

    //     return $array;
    // }
}
