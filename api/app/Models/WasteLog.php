<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class WasteLog extends Model {
    protected $fillable = ['food_category', 'weight', 'image_path', 'suggestion'];
}
