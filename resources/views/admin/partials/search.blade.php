@extends('admin.layouts.app')

@section('title', __('Поиск'))
@section('page_title', __('Поиск'))

@section('header')
    <p class="text-muted mb-0 mt-1">{{ __('Результаты поиска по страницам админ-панели.') }}</p>
@endsection

@section('content')
    <div class="mt-4">
        @if ($query === '')
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-2">{{ __('Поиск') }}</h5>
                    <p class="text-muted mb-0">{{ __('Введите название страницы в верхней строке поиска, чтобы найти доступные разделы.') }}</p>
                </div>
            </div>
        @elseif ($results->isEmpty())
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-2">{{ __('Ничего не найдено') }}</h5>
                    <p class="text-muted mb-0">{{ __('Для запроса') }} "<strong>{{ $query }}</strong>" {{ __('ничего не найдено в админ-панели.') }}</p>
                </div>
            </div>
        @else
            <div class="row">
                @foreach ($results as $result)
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-2">{{ $result['title'] }}</h5>
                                <p class="text-muted mb-3">{{ $result['description'] }}</p>
                                <a href="{{ $result['route'] }}" class="btn btn-primary">{{ __('Открыть') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
