<?php

namespace Mawuekom\Systhemer\Theme\Builder;

use Mawuekom\Systhemer\Traits\HandleFiles;

class StubManager
{
    use HandleFiles;

    /**
     * Theme stub directory
     *
     * @var string
     */
    private $stubDirectoryPath;

    /**
     * Theme stub files.
     *
     * @var array
     */
    private $stubs = [];

    /**
     * Stub file variables.
     *
     * @var array
     */
    private $stubData = [];

    /**
     * Create new StubManager instance.
     *
     * @param string $stubDirectoryPath
     * 
     * @return void
     */
    public function __construct(string $stubDirectoryPath, array $stubData)
    {
        $this ->stubDirectoryPath = $stubDirectoryPath;
        $this ->stubData = $stubData;
        $this ->getStub();
    }

    /**
     * Get the stub path and the stub variables and render all.
     *
     * @return bool|mixed|string
     */
    public function getStubTemplate()
    {
        $renderStubs = [];

        foreach ($this ->stubs as $key => $stub) {
            $renderStubs[$key]['file_content']      = $this ->updateStubContents($stub['file_content'], $this ->stubData);
            $renderStubs[$key]['source_file_path']  = $stub['source_file_path'];
        }

        return $renderStubs;
    }
    
    /**
     * Get stub files
     * 
     * @return array
     */
    private function getStub()
    {
        $files = $this ->getAllFiles($this ->stubDirectoryPath);
        $stubs = [];

        foreach ($files as $file) {
            $stubs[] = $this ->resolveStubSourceFilePath($file ->getPathName());
        }

        return $this ->stubs = $stubs;
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param string $stub
     * @param array $stubData
     *
     * @return bool|mixed|string
     */
    private function updateStubContents($stub, $stubData)
    {
        foreach ($stubData as $search => $replace) {
            $stub = str_replace('{{ '.$search.' }}', $replace, $stub);
        }

        return $stub;
    }

    /**
     * Resolve stub sources file path
     *
     * @param string $path
     *
     * @return array
     */
    private function resolveStubSourceFilePath($path)
    {
        $data = explode($this ->stubDirectoryPath, $path);

        return [
            'file_content' => $this ->getFileContent($path),
            'source_file_path' => (str_contains($data[1], '.stub')) 
                                    ? explode('.stub', $data[1])[0] 
                                    : $data
        ];
    }
}