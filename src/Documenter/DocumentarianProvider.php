<?php

namespace Davidhsianturi\Compass\Documenter;

use Davidhsianturi\Compass\Compass;
use Mpociot\Documentarian\Documentarian;
use Davidhsianturi\Compass\Contracts\RequestRepository;
use Davidhsianturi\Compass\Contracts\DocumenterRepository;

class DocumentarianProvider implements DocumenterRepository
{
    /**
     * @var \Mpociot\Documentarian\Documentarian
     */
    protected $generator;

    /**
     * @var \Davidhsianturi\Compass\Contracts\RequestRepository
     */
    protected $resources;

    /**
     * Create a new documentarian provider instance.
     *
     * @param  \Mpociot\Documentarian\Documentarian  $generator
     * @param  \Davidhsianturi\Compass\Contracts\RequestRepository  $resources
     * @return void
     */
    public function __construct(Documentarian $generator, RequestRepository $resources)
    {
        $this->generator = $generator;
        $this->resources = $resources;
    }

    /**
     * Build documentation resources from storage.
     *
     * @return false|null
     */
    public function build()
    {
        $contents = $this->viewContents();
        $settings = $this->markdownConfig();

        // Build routes output.
        $routesOutput = Compass::getAppRoutes()->map(function ($route) use ($settings, $contents) {
            $route = $this->resources->find($route['route_hash']);

            collect($route->examples)->each(function ($example) {
                $example->content = json_decode($example->content);
            });

            $route->content['output'] = (string) view($contents['route'])
                ->with('route', $route)
                ->with('settings', $settings)
                ->with('baseUrl', config('app.url'))
                ->render();

            return $route;
        })->values();

        $parsedRoutesOutput = Compass::groupingRoutes($routesOutput);
        $infoText = view($contents['info']);
        $frontmatter = view($contents['frontmatter'])->with('settings', $settings);

        $markdownFiles = $this->markdownFiles();
        $prependFileContents = file_exists($markdownFiles['prepend']) ? file_get_contents($markdownFiles['prepend'])."\n" : '';
        $appendFileContents = file_exists($markdownFiles['append']) ? "\n".file_get_contents($markdownFiles['append']) : '';

        // @todo should we check if the documentation was modified and skip the modified parts of the routes ?

        $this->writeContents($appendFileContents, $prependFileContents, $parsedRoutesOutput, $frontmatter, $infoText);

        return $this->generator->generate($markdownFiles['path']);
    }

    /**
     * Rebuild documentation resources from existing markdown files.
     *
     * @return false|null
     */
    public function rebuild()
    {
        $markdownFiles = $this->markdownFiles();

        if (! is_dir($markdownFiles['path'])) {
            // throw an exception?
            return false;
        }

        return $this->generator->generate($markdownFiles['path']);
    }

    /**
     * Write contents to markdown files.
     *
     * @param  string  $appendFileContents
     * @param  string  $prependFileContents
     * @param  \Illuminate\Support\Collection  $parsedRoutesOutput
     * @param  \Illuminate\View\View|\Illuminate\Contracts\View\Factory|string  $frontmatter
     * @param  \Illuminate\View\View|\Illuminate\Contracts\View\Factory  $infoText
     * @return int|false
     */
    protected function writeContents($appendFileContents, $prependFileContents, $parsedRoutesOutput, $frontmatter, $infoText)
    {
        $markdownFiles = $this->markdownFiles();

        if (! is_dir($markdownFiles['path'])) {
            $this->generator->create($markdownFiles['path']);
        }

        $contents = view('compass::documenter.documentarian.layout')
            ->with('appendMd', $appendFileContents)
            ->with('prependMd', $prependFileContents)
            ->with('parsedRoutes', $parsedRoutesOutput)
            ->with('frontmatter', $frontmatter)
            ->with('infoText', $infoText)
            ->with('outputPath', $markdownFiles['path']);

        file_put_contents($markdownFiles['index'], $contents);
    }

    /**
     * The markdown files collection.
     *
     * @return array
     */
    protected function markdownFiles()
    {
        $outputPath = config('compass.provider.documentarian.output');

        return [
            'path' => $outputPath,
            'index' => $outputPath.DIRECTORY_SEPARATOR.'source'.DIRECTORY_SEPARATOR.'index.md',
            'append' => $outputPath.DIRECTORY_SEPARATOR.'source'.DIRECTORY_SEPARATOR.'append.md',
            'compare' => $outputPath.DIRECTORY_SEPARATOR.'source'.DIRECTORY_SEPARATOR.'compare.md',
            'prepend' => $outputPath.DIRECTORY_SEPARATOR.'source'.DIRECTORY_SEPARATOR.'prepend.md',
        ];
    }

    /**
     * The markdown files configuration.
     *
     * @return array
     */
    protected function markdownConfig()
    {
        return [
            'languages' => config('compass.provider.documentarian.example_requests'),
        ];
    }

    /**
     * Get the evaluated contents for view.
     *
     * @return array
     */
    protected function viewContents()
    {
        $documentarian = 'compass::documenter.documentarian.';

        return [
            'layout' => $documentarian.'layout',
            'info' => $documentarian.'partials.info',
            'route' => $documentarian.'partials.route',
            'frontmatter' => $documentarian.'partials.frontmatter',
        ];
    }
}
