<?php

namespace Mawuekom\Systhemer\Theme;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

class Theme implements Arrayable
{
    /**
     * Theme name
     * 
     * @var string
     */
    private $name;

    /**
     * Theme description
     * 
     * @var string
     */
    private $description;

    /**
     * Theme parent
     * 
     * @var null|string
     */
    private $parent;

    /**
     * Absolute path of where the theme can be found on the disk.
     *
     * @var string
     */
    private $path;

    /**
     * Theme just needs to know one thing - where the theme is found. It'll do the rest.
     *
     * @param string $name
     * @param string|null $description
     * @param string|null $path Absolute path on the filesystem to the theme
     * @param string|null $parent
     * 
     * @return void
     */
    public function __construct($name, $description = null, $path = null, $parent = null)
    {
        $this->name = $name;
        $this->description = $description;
        $this->parent = $parent;
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return null|string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Determines whether or not a theme has a parent.
     *
     * @return bool
     */
    public function hasParent()
    {
        return !!$this->parent;
    }

    /**
     * Return the asset path to the theme.
     *
     * @return string
     */
    public function getAssetPath()
    {
        return Str::slug($this->getName());
    }
    
    /**
     * Returns the theme object as an array, containing all theme information.
     *
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}