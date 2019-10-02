<!-- START_{{$route->id}} -->
## {{$route->title}}
@if ($route->description)

{{$route->description}}
@endif

@if (count($route->examples))
@foreach ($route->examples as $example)
> {{$example->title}} :

@foreach($settings['languages'] as $language)
@include("compass::documentarian.partials.example-requests.$language")

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

@if (array_key_exists('body', $route->content))
@foreach ($route->content['body'] as $param)
@if ($param['included'])
#### Parameters

Key | Description
--------- | -----------
{{$param['key']}} | {{$param['description']}}
@endif
@endforeach
@endif

<!-- END_{{$route->id}} -->
