<?php

namespace Davidhsianturi\Compass\Tests\Compass;

use Davidhsianturi\Compass\Tests\DocsTestCase;
use Davidhsianturi\Compass\Storage\RouteModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Davidhsianturi\Compass\Storage\DatabaseRequestRepository;

class SlateBuilderTest extends DocsTestCase
{
    use RefreshDatabase;

    protected $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->loadFactoriesUsing($this->app, __DIR__.'/../../src/Storage/factories');

        $this->repository = new DatabaseRequestRepository('testbench');
    }

    public function test_build_and_write_contents_to_markdown_files()
    {
        $this->createRouteExample();
        $this->artisan('compass:build');

        $fixtureMarkdown = __DIR__.'/../Fixtures/index.md';
        $generatedMarkdown = __DIR__.'/../../public/docs/source/index.md';

        $this->assertFilesHaveSameContent($fixtureMarkdown, $generatedMarkdown);
    }

    public function test_builder_can_prepend_and_append_data_to_generated_markdown()
    {
        $this->createRouteExample();
        $this->artisan('compass:build');

        $prependMarkdown = __DIR__.'/../Fixtures/prepend.md';
        $appendMarkdown = __DIR__.'/../Fixtures/append.md';
        $generatedMarkdown = __DIR__.'/../../public/docs/source/index.md';

        copy($prependMarkdown, __DIR__.'/../../public/docs/source/prepend.md');
        copy($appendMarkdown, __DIR__.'/../../public/docs/source/append.md');

        $this->artisan('compass:build');
        $this->assertContainsIgnoringWhitespace($this->getFileContents($prependMarkdown), $this->getFileContents($generatedMarkdown));
        $this->assertContainsIgnoringWhitespace($this->getFileContents($appendMarkdown), $this->getFileContents($generatedMarkdown));
    }

    protected function createRouteExample()
    {
        $this->registerExampleRoute();

        $routes = $this->repository->get();

        return $routes->map(function ($route) {
            return factory(RouteModel::class)->create([
                'route_hash' => $route->id,
                'title' => 'Get example',
                'content' => [
                    'request' => $route,
                    'response' => json_decode(file_get_contents(__DIR__.'/../Fixtures/response_test.json')),
                ],
                'example' => true,
            ]);
        });
    }
}
