<?php

namespace Davidhsianturi\Compass\Tests;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Illuminate\Support\Facades\Route as RouteFacade;

class DocumenterHelper extends TestCase
{
    protected function tearDown(): void
    {
        $this->deleteDirectoryAndContents('/public/docs');
    }

    protected function registerExampleRoute()
    {
        RouteFacade::get('/example', function () {
            return 'example for api docs';
        })->name('example');
    }

    /**
     * Assert that two files content have the same value
     * .
     * @source laravel-apidoc-generator
     * @link https://github.com/mpociot/laravel-apidoc-generator/blob/0ed20a0c253d27ebfbee3cea001f6101c70e2ee0/tests/TestHelpers.php#L22
     *
     * @param  string  $pathToExpected
     * @param  string  $pathToActual
     * @return void
     */
    protected function assertFilesHaveSameContent($pathToExpected, $pathToActual)
    {
        $actual = $this->getFileContents($pathToActual);
        $expected = $this->getFileContents($pathToExpected);

        $this->assertSame($expected, $actual);
    }

    /**
     * Get the contents of a file in a cross-platform-compatible way.
     *
     * @source laravel-apidoc-generator
     * @link https://github.com/mpociot/laravel-apidoc-generator/blob/0ed20a0c253d27ebfbee3cea001f6101c70e2ee0/tests/TestHelpers.php#L36
     *
     * @param  string  $path
     * @return string
     */
    protected function getFileContents($path)
    {
        return str_replace("\r\n", "\n", file_get_contents($path));
    }

    /**
     * Delete API Documentation folder.
     *
     * @source laravel-apidoc-generator
     * @link https://github.com/mpociot/laravel-apidoc-generator/blob/0ed20a0c253d27ebfbee3cea001f6101c70e2ee0/src/Tools/Utils.php#L87
     *
     * @param  string  $dir
     * @return bool
     */
    protected function deleteDirectoryAndContents($dir)
    {
        $adapter = new Local(realpath(__DIR__.'/../'));
        $fs = new Filesystem($adapter);
        $fs->deleteDir($dir);
    }

    /**
     * Assert that a string contains another string, ignoring all whitespace.
     *
     * @source laravel-apidoc-generator
     * @link https://github.com/mpociot/laravel-apidoc-generator/blob/0ed20a0c253d27ebfbee3cea001f6101c70e2ee0/tests/TestHelpers.php#L47
     *
     * @param  $needle
     * @param  $haystack
     * @return void
     */
    protected function assertContainsIgnoringWhitespace($needle, $haystack)
    {
        $needle = preg_replace('/\s/', '', $needle);
        $haystack = preg_replace('/\s/', '', $haystack);

        $this->assertStringContainsString($needle, $haystack);
    }
}
