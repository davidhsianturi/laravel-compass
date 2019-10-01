<?php

namespace Davidhsianturi\Compass\Tests\Compass;

use Davidhsianturi\Compass\Compass;
use Davidhsianturi\Compass\Tests\DocsTestCase;
use Davidhsianturi\Compass\Storage\RouteModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SlateBuilderTest extends DocsTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->loadFactoriesUsing($this->app, __DIR__.'/../../src/Storage/factories');
    }

    public function test_build_and_write_contents_to_markdown_files()
    {
        $this->createRouteExample();
        $this->artisan('compass:build');

        $generatedMarkdown = __DIR__.'/../../public/docs/source/index.md';
        $fixtureMarkdown = __DIR__.'/../Fixtures/index.md';

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

        $responseData = $this->responseFactory();

        return Compass::getAppRoutes()->map(function ($route) use ($responseData) {
            return factory(RouteModel::class)->create([
                'route_hash' => $route['route_hash'],
                'title' => 'Get example',
                'content' => [
                    'request' => $route,
                    'response' => $responseData,
                ],
                'example' => true,
            ]);
        });
    }

    protected function responseFactory()
    {
        return [
            'data' => [
                'id' => 5,
                'name' => 'Jessica Jones',
                'gender' => 'female',
            ],
            'headers' => [],
            'status' => '200',
            'statusText' => 'OK',
        ];
    }
}
