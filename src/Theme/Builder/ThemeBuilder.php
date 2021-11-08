<?php

namespace Mawuekom\Systhemer\Theme\Builder;

use Illuminate\Filesystem\Filesystem;
use Mawuekom\Systhemer\Exceptions\ThemeAlreadyExists;
use Mawuekom\Systhemer\Theme\Theme;
use Mawuekom\Systhemer\Traits\HandleFiles;

class ThemeBuilder
{
    use HandleFiles;

    /**
     * Theme instance
     * 
     * @var \Mawuekom\Systhemer\Theme\Theme
     */
    private $theme;

    /**
     * Theme stub directory
     *
     * @var string
     */
    private $themeStubDirectory;

    /**
     * Theme stub file.
     *
     * @var array
     */
    private $stubs = [];

    public function __construct(Theme $theme)
    {
        $this ->theme = $theme;
        $this ->themeStubDirectory = stub_directory_path('theme');
        $this ->stubs = $this ->getStub();
    }

    /**
     * Get theme object
     *
     * @return \Mawuekom\Systhemer\Theme\Theme
     */
    public function getTheme()
    {
        return $this ->theme;
    }

    public function execute()
    {
        if (systhemer() ->themeExists($this ->theme ->getName())) {
            throw new ThemeAlreadyExists($this ->theme ->getName());
        }

        $this ->ensureDirectoryExists($this ->theme ->getPath());

        $templates = $this ->getStubTemplate();

        foreach ($templates as $template) {
            $this ->putContentInFile(
                $this ->theme ->setFilePath($template['source_file_path']), 
                $template['file_content']
            );
        }
    }

    /**
     * Get theme stub files
     * 
     * @return array
     */
    private function getStub()
    {
        $files = $this ->getAllFiles($this ->themeStubDirectory);
        $stubs = [];

        foreach ($files as $file) {
            $stubs[] = $this ->resolveStubSourceFilePath($file ->getPathName());
        }

        return $stubs;
    }

    /**
     * Map the stub variables present in stub to its value
     * 
     * @return array
     */
    private function getStubData()
    {
        return [
            'name' => $this ->theme ->getName(),
        ];
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
     * Get the stub path and the stub variables and render all.
     *
     * @return bool|mixed|string
     */
    private function getStubTemplate()
    {
        $stubData = $this ->getStubData();
        $renderStubs = [];

        foreach ($this ->stubs as $key => $stub) {
            $renderStubs[$key]['file_content'] = $this ->updateStubContents($stub['file_content'], $stubData);
            $renderStubs[$key]['source_file_path'] = $stub['source_file_path'];
        }

        return $renderStubs;
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
        $data = explode($this ->themeStubDirectory, $path);

        return [
            'file_content' => $this ->getFileContent($path),
            'source_file_path' => (str_contains($data[1], '.stub')) 
                                    ? explode('.stub', $data[1])[0] 
                                    : $data
        ];
    }
}