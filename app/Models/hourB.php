<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class hourB extends Model
{
    use HasFactory;

    use SoftDeletes;


    protected $fillable = ['name','serial','current','max'];
    protected $dates = ['deleted_at'];
     /**
     * Boot method to handle model events.
     */
    protected static function boot()
    {
        parent::boot();

        // Use the saving event to adjust the decimal parts
        static::saving(function ($hourb) {
            $hourb->current = $hourb->adjustDecimal($hourb->current);
            $hourb->max = $hourb->adjustDecimal($hourb->max);
        });
    }

    /**
     * Adjust the decimal part of a number to ensure it is <= 59.
     *
     * @param float|null $value
     * @return float|null
     */
    private function adjustDecimal($value)
    {
        if ($value === null) {
            return null; // If null, return null
        }

        $integerPart = floor($value); // Extract the integer part
        $decimalPart = round(($value - $integerPart) * 100); // Extract and scale the decimal part

        if ($decimalPart > 59) {
            $integerPart += floor($decimalPart / 60); // Carry over excess
            $decimalPart %= 60; // Remainder as the new decimal part
        }

        return $integerPart + ($decimalPart / 100); // Combine back
    }
}

