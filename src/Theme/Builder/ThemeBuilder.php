<?php

namespace Mawuekom\Systhemer\Theme\Builder;

use Mawuekom\Systhemer\Exceptions\ThemeAlreadyExists;
use Mawuekom\Systhemer\Theme\Builder\StubManager;
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

    public function __construct(Theme $theme)
    {
        $this ->theme = $theme;
        $this ->themeStubDirectory = stub_directory_path('theme');
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

    /**
     * Execute theme builder
     *
     * @return void
     */
    public function execute()
    {
        if (systhemer() ->themeExists($this ->theme ->getName())) {
            throw new ThemeAlreadyExists($this ->theme ->getName());
        }

        $this ->ensureDirectoryExists($this ->theme ->getPath());

        $templates = $this ->initStubManager() ->getStubTemplate();

        foreach ($templates as $template) {
            $this ->ensureThemeSubDirectoryExists($template['source_file_path']);

            $this ->putContentInFile(
                $this ->theme ->setFilePath($template['source_file_path']), 
                $template['file_content']
            );
        }
    }

    /**
     * Init StubManager object
     *
     * @return \Mawuekom\Systhemer\Theme\Builder\StubManager
     */
    public function initStubManager()
    {
        return new StubManager($this ->themeStubDirectory, $this ->getStubData());
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
     * Ensure theme directories exists
     *
     * @param string $path
     *
     * @return void
     */
    public function ensureThemeSubDirectoryExists($path)
    {
        $pathComponents = explode('/', $path);
        $pathFolders = rtrim($path, end($pathComponents));

        if ($pathFolders !== '/')
            $this ->ensureDirectoryExists($this ->theme ->setFilePath($pathFolders));
    }
}