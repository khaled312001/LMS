@extends('layouts.default')
@push('title', get_phrase('Bootcamps'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!------------------- Breadcum Area Start  ------>
    <section class="breadcum-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eNtry-breadcum">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">{{ get_phrase('Home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('All Bootcamps') }}</li>
                            </ol>
                        </nav>
                        <h3 class="g-title">{{ get_phrase('All Bootcamps') }}</h3>
                    </div>
                </div>
            </div>
            <div class="row align-items-center mt-3">
                <div class="col-lg-8 col-md-6 col-sm-6 col-6">
                    <p class="showing-text">
                        {{ get_phrase('Showing') . ' ' . ($bootcamps->count() ?? 0) . ' ' . get_phrase('of') . ' ' . ($bootcamps->total() ?? 0) . ' ' . get_phrase('data') }}
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!------------------- Breadcum Area End  --------->



    <!-------------- List Item Start   --------------->
    <div class="eNtery-item">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    @include('frontend.default.bootcamp.filter')
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="row">
                        @if (isset($bootcamps) && $bootcamps->count() > 0)
                            @foreach ($bootcamps as $bootcamp)
                                @include('frontend.default.bootcamp.bootcamp_grid')
                            @endforeach
                        @else
                            <div class="col-12">
                                <p class="text-center">{{ get_phrase('No bootcamps found.') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            @if (isset($bootcamps) && $bootcamps->count() > 0)
                <div class="entry-pagination">
                    <nav aria-label="Page navigation example">
                        {{ $bootcamps->links() }}
                    </nav>
                </div>
            @endif
            <!-- Pagination -->
        </div>
    </div>
    <!-------------- List Item End  --------------->
@endsection
@push('js')@endpush
