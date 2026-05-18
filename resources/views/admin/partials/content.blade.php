@php
    $pageHeading = trim($__env->yieldContent('page_title', $__env->yieldContent('title')));
    $hasPageHeader = $pageHeading !== '' || trim($__env->yieldContent('header')) !== '';
@endphp

<main class="content-page">
    <div class="admin-content-shell">
        @if ($hasPageHeader)
            <div class="admin-page-header">
                @if ($pageHeading !== '')
                    <h1 class="admin-page-title">{{ $pageHeading }}</h1>
                @endif

                <div class="admin-page-subtitle">
                    @yield('header')
                </div>
            </div>
        @endif

        @yield('content')
    </div>
</main>
