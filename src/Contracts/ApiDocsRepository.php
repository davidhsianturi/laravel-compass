<?php

namespace Davidhsianturi\Compass\Contracts;

interface ApiDocsRepository
{
    /**
     * Build API documentation from storage.
     *
     * @return false|null
     */
    public function build();

    /**
     * Rebuild API documentation from markdown file.
     *
     * @return false|null
     */
    public function rebuild();
}
