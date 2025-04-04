<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class WithinSixMonths implements Rule
{
    public function passes($attribute, $value)
    {
        $fromDate = request()->input('from_date');

        if (!$fromDate) {
            return false;
        }

        $startDate = Carbon::parse($fromDate);
        $endDate = Carbon::parse($value);

        return $endDate->lte($startDate->copy()->addMonths(6));
    }

    public function message()
    {
        return 'The :attribute must be within six months of the start date.';
    }
}
