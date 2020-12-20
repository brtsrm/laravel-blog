<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class categorySeeder extends Model
{
    use HasFactory;
    protected $table = "categories";

    public function articleCount(){
        return $this->hasMany(articleSeeder::class,'category_id','id')->where('status',1)->count();
    }

}
