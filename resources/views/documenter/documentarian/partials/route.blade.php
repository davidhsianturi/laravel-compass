<!-- START_{{$route->id}} -->
## {{$route->title}}
@if ($route->description)

{{$route->description}}
@endif

@if (count($route->examples))
@foreach ($route->examples as $example)
> {{$example->title}} :

@foreach($settings['languages'] as $language)
@include("compass::documenter.documentarian.partials.example-requests.$language")

@endforeach


> Example response ({{$example->content->response->status}}) :

```json
{!! json_encode($example->content->response->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
```
@endforeach
@else

> No example provided.
@endif

### HTTP Request
@foreach ($route->info['methods'] as $method)
`{{$method}} {{$route->info['uri']}}`
@endforeach

@if (array_key_exists('params', $route->content))
@foreach ($route->content['params'] as $param)
@if ($param['included'])
#### Query Parameters

Key | Description
--------- | -----------
{{$param['key']}} | {{$param['description']}}
@endif
@endforeach
@endif

<!-- END_{{$route->id}} -->
