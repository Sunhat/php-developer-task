<?php

namespace App\Services;

use Storage;
use Illuminate\Support\Collection;

abstract class Output
{
    protected $output;
    protected $filename;
    protected $folder = '';

    public function __construct(Collection $data)
    {
        $this->output = $this->generateOutput($this->build($data));
        $this->filename = $this->generateFilename();
    }

    protected function generateFilename()
    {
        return date('Y_m_d_His') . '_' . uniqid();
    }

    final public function getOutput()
    {
        return $this->output;
    }

    final public function save()
    {
        Storage::disk('local')->put($this->folder . '/' . $this->filename, $this->output);
        return Storage::disk('local')->getAdapter()->applyPathPrefix($this->folder . '/' . $this->filename);
    }

    final public function getShortStoragePath()
    {
        return $this->folder . '/' . $this->filename;
    }

    final public function getFilename()
    {
        return $this->filename;
    }

    final public function getDownloadFilename()
    {
        return str_replace('/', '-', $this->folder) . '-' . $this->filename;
    }

    abstract protected function generateOutput(array $data);
    abstract protected function build(Collection $data): array;
}
