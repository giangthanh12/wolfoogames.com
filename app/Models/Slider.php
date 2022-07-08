<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'title',
        'images',
        'is_active'
    ];
    public function total_slide($string) {
        if(is_null($string)) return 0;
        return count(explode(",",$string));
    }
    public function getTotalSlideAttribute() {
        if(is_null($this->images)) return 0;
        return count(explode(",",$this->images));
    }
}
