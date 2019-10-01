---
{!! $frontmatter !!}
---
<!-- START_INFO -->
{!! $infoText !!}
<!-- END_INFO -->
{!! $prependMd !!}
@foreach($parsedRoutes as $groupName => $routes)
#{!! $groupName !!}


@foreach($routes as $route)
{!! $route->content['output'] !!}
@endforeach
@endforeach{!! $appendMd !!}
