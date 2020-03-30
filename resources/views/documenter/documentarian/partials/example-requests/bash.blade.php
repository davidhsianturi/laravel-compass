```bash
curl -X {{$example->content->request->content->selectedMethod}} {{$example->content->request->content->selectedMethod == 'GET' ? '-G ' : ''}}"{{ rtrim($baseUrl, '/')}}/{{ ltrim($example->content->request->content->url, '/') }}" \
@if(is_object($example->content->request->content) || count($example->content->request->content->headers))
@foreach($example->content->request->content->headers as $header)
@if ($header->included)
    -H "{{$header->key}}: {{$header->value}}" \
@endif
@endforeach
@endif

```