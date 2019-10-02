```bash
curl -X {{$example->content->request->info->methods[0]}} {{$example->content->request->info->methods[0] == 'GET' ? '-G ' : ''}}"{{ rtrim($baseUrl, '/')}}/{{ ltrim($example->content->request->info->uri, '/') }}" \
@if(is_object($example->content->request->content) || count($example->content->request->content))
@foreach($example->content->request->content->headers as $header)
@if ($header->included)
    -H "{{$header->key}}: {{$header->value}}" \
@endif
@endforeach
@endif

```