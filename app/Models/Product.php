<?php

namespace App\Models;

use App\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'section_id',
        'description'
    ];

   /**
    * Get the section that owns the Product
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function section()
   {
       return $this->belongsTo(Section::class);
   }
}
