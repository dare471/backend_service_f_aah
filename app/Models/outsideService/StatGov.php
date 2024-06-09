<?php

namespace App\Models\outsideService;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StatGov extends Model
{
    use HasFactory;
    protected $table = 'schedule_stat_gov';
    public $incrementing = false;  // Указывает Laravel, что ID не автоинкрементное
    protected $keyType = 'string';  // Тип ключа - строка
   
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }
    protected $fillable = [
        'id',
        'bin',
        'from',
        'created_at',
        'updated_at'
    ];
}
