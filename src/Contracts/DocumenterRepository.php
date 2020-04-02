<?php

namespace Davidhsianturi\Compass\Contracts;

interface DocumenterRepository
{
    /**
     * Build documentation resources from storage.
     *
     * @return false|null
     */
    public function build();

    /**
     * Rebuild documentation resources from existing markdown files.
     *
     * @return false|null
     */
    public function rebuild();
}
