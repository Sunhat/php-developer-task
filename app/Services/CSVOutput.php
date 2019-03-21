<?php

namespace App\Services;

use App\Exceptions\InvalidCSVArrayException;
use Illuminate\Support\Collection;

class CSVOutput extends Output
{
    public const DEFAULT_STORAGE_DISK = 'local';

    protected $delimeter;
    protected $separator;


    public function __construct(Collection $data, string $delimeter = '"', string $separator = ',')
    {
        $this->delimeter = $delimeter;
        $this->separator = $separator;
        parent::__construct($data);
    }

    protected function generateOutput(array $data)
    {
        // Create columns, and apply ucfirst
        $column_names = array_map('ucfirst', array_keys($data[0]));
        // Add column names to csv
        $output = $this->createRow($column_names);
        // Create rows of data
        foreach ($data as $cols) {
            $output .= $this->createRow($cols);
        }
        return $output;
    }

    protected function createRow($cols)
    {
        foreach ($cols as &$item) {
            $this->validateItem($item);
            // Replaces a double quote with two double quotes
            $item = str_replace('"', '""', $item);
        }
        // wrap items in delimeter, and separate by seperator
        return $this->delimeter . implode($this->delimeter.$this->separator.$this->delimeter, $cols) . $this->delimeter ."\n";
    }

    protected function validateItem($item)
    {
        if (!is_scalar($item) && $item !== null) {
            throw new InvalidCSVArrayException(gettype($item) . ' given');
        }
    }

    protected function generateFilename()
    {
        return parent::generateFilename() . '.csv';
    }


    protected function build(Collection $data): array
    {
        return $data->toArray();
    }
}
