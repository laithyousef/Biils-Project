<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'sections' ;
    protected $fillable = [
        'section_name',
        'description',
    ];

    use HasFactory;

    /**
     * Get all of the product for the Section
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product(): HasMany
    {
        return $this->hasMany(Product::class, 'foreign_key', 'local_key');
    }

    /**
     * Get all of the invoice for the Section
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoice()
    {
        return $this->hasMany(Invoices::class);
    }
}
