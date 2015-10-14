<?php namespace Arcanedev\SeoHelper\Entities;

use Arcanedev\SeoHelper\Contracts\Entities\MetaInterface;

/**
 * Class     Meta
 *
 * @package  Arcanedev\SeoHelper\Entities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Meta implements MetaInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Meta prefix name.
     *
     * @var string
     */
    protected $prefix  = '';

    /**
     * Meta name.
     *
     * @var string
     */
    protected $name    = '';

    /**
     * Meta content.
     *
     * @var string
     */
    protected $content = '';

    /**
     * List of links tags instead of metas tags.
     *
     * @var array
     */
    protected $links = [
        'alternate', 'archives', 'author', 'canonical', 'first', 'help', 'icon', 'index', 'last',
        'license', 'next', 'nofollow', 'noreferrer', 'pingback', 'prefetch', 'prev', 'publisher'
    ];

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make Meta instance.
     *
     * @param  string  $name
     * @param  string  $content
     * @param  string  $prefix
     */
    public function __construct($name, $content, $prefix = '')
    {
        $this->setPrefix($prefix);
        $this->setName($name);
        $this->setContent($content);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters and Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the meta name.
     *
     * @return string
     */
    public function key()
    {
        return $this->name;
    }

    /**
     * Set the meta prefix name.
     *
     * @param  string  $prefix
     *
     * @return self
     */
    private function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get the meta name.
     *
     * @return string
     */
    private function getName()
    {
        return $this->prefix . $this->name;
    }

    /**
     * Set the meta name.
     *
     * @param  string  $name
     *
     * @return self
     */
    private function setName($name)
    {
        $name = strtolower(trim($name));

        $this->name = $name;

        return $this;
    }

    /**
     * Set the meta content.
     *
     * @param  string  $content
     *
     * @return self
     */
    private function setContent($content)
    {
        if (is_string($content)) {
            $this->content = trim($content);
        }

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make Meta instance.
     *
     * @param  string  $name
     * @param  string  $content
     * @param  string  $prefix
     *
     * @return self
     */
    public static function make($name, $content, $prefix = '')
    {
        return new self($name, $content, $prefix);
    }

    /**
     * Render the tag.
     *
     * @return string
     */
    public function render()
    {
        if ($this->isLink()) {
            return $this->renderLink();
        }

        return $this->renderMeta();
    }

    /**
     * Render the link tag.
     *
     * @return string
     */
    private function renderLink()
    {
        return '<link rel="' . $this->name . '" href="' . $this->content . '">';
    }

    /**
     * Render the meta tag.
     *
     * @return string
     */
    private function renderMeta()
    {
        return '<meta name="' . $this->getName() . '" content="' . $this->content . '">';
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if meta is a link tag.
     *
     * @return bool
     */
    protected function isLink()
    {
        return in_array($this->name, $this->links);
    }

    /**
     * Check if meta is valid.
     *
     * @return bool
     */
    public function isValid()
    {
        return ! empty($this->content);
    }
}