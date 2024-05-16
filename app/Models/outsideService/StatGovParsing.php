<?php

namespace App\Models\outsideService;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StatGovParsing extends Model
{
    use HasFactory;
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
        'fullName',
        'nameOrg',
        'okedCode',
        'okedName',
        'secondOkeds',
        'krpCode',
        'krpName',
        'economicSectorCode',
        'economicSectorName',
        'registeredAddress',
        'typeOrg',
        'registerDate',
        'cfoCode',
        'cfoName',
        'created_at',
        'updated_at'
    ];
}
