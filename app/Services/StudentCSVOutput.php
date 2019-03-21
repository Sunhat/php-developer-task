<?php

namespace App\Services;

use App\Models\Student;
use Illuminate\Support\Collection;

class StudentCSVOutput extends CSVOutput
{
    protected $folder = 'students';
    /**
     * Currently, PHP has invariant type-hinting,
     * this means we cannot require a specific type of Collection,
     * such as a Eloquent\Collection.
     * https://wiki.php.net/rfc/covariant-returns-and-contravariant-parameters
     * Covariance has been accepted for 7.4, enabling a better implementation
     */
    protected function build(Collection $data): array
    {
        // What we can do enforce a type-hint for a Student Model here
        return $data->map(function (Student $item) {
            return [
                'firstname' => $item->firstname,
                'email' => $item->surname,
                'university' => $item->course ? $item->course->university : null,
                'course' => $item->course ? $item->course->course_name : null,
            ];
        })
        ->toArray();
    }
}
