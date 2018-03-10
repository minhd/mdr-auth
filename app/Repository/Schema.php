<?php

namespace MinhD\Repository;


class Schema
{
    public $title;
    public $content;
    public $manifest;
    private $validator;

    /**
     * Schema constructor.
     */
    public function __construct($manifest)
    {
        $this->manifest = $manifest;
        $this->init();
    }

    public function init()
    {
        $slug = $this->manifest['slug'];
        $config = config("schema.$slug");
        $this->title = $this->manifest['title'];
        $this->content = (new SchemaRepository())->getContent($this);
        $this->validator = $config['validator'] ? new $config['validator']() : null;
    }

    public function validate($payload)
    {
        if ($this->validator) {
            return $this->validator->validate($payload);
        }

        return true;
    }
}
