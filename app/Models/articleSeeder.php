<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class articleSeeder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "articles";
    public function getCategory(){
        return $this->hasOne(categorySeeder::class,"id","category_id");
    }
}
