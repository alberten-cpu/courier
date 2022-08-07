<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ __($title) }}</h1>
            </div>
            @if($breadcrumbOn)
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @foreach($breadcrumbs as $breadcrumb => $route)
                            <li class="breadcrumb-item @if(isset($route) && (url(request()->route()->uri())==Helper::getRoute($route))) active @endif">
                                @if(!$route)
                                    {{ __($breadcrumb) }}
                                @else
                                    <a href="{{ Helper::getRoute($route) }}">{{ __($breadcrumb) }}</a>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </div>
            @endif
        </div>
    </div>
</section>
