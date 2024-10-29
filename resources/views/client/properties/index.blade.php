@extends('layouts.app')

@section('content')
<!-- Content start -->

<!-- Property List Start -->
<div class="container-xxl py-5">
    <div class="container">
        <!-- Header Section -->
        <div class="row g-0 gx-5 align-items-end mb-4">
            <div class="col-lg-6">
                <div class="text-start mx-auto wow slideInLeft" data-wow-delay="0.1s">
                    <h1 class="mb-3">Explore Our Properties</h1>
                    <p>Find your perfect property from our extensive collection of listings.</p>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="col-lg-6">
                <div class="search-filters wow slideInRight" data-wow-delay="0.1s">
                    <!-- Status Filter -->
                    <ul class="nav nav-pills d-flex justify-content-lg-end mb-3">
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-primary {{ !request('status') ? 'active' : '' }}"
                               href="{{ request()->url() }}">All Properties</a>
                        </li>
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-primary {{ request('status') === 'for_sale' ? 'active' : '' }}"
                               href="{{ request()->fullUrlWithQuery(['status' => 'for_sale']) }}">For Sale</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-primary {{ request('status') === 'for_rent' ? 'active' : '' }}"
                               href="{{ request()->fullUrlWithQuery(['status' => 'for_rent']) }}">For Rent</a>
                        </li>
                    </ul>

                    <!-- Advanced Filters -->
                    <form action="{{ route('client.properties.index') }}" method="GET" class="row g-3">
                        <div class="col-md-6">
                            <select name="type" class="form-select">
                                <option value="">Property Type</option>
                                <option value="house" {{ request('type') === 'house' ? 'selected' : '' }}>House</option>
                                <option value="apartment" {{ request('type') === 'apartment' ? 'selected' : '' }}>Apartment</option>
                                <option value="villa" {{ request('type') === 'villa' ? 'selected' : '' }}>Villa</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select name="price_range" class="form-select">
                                <option value="">Price Range</option>
                                <option value="0-100000" {{ request('price_range') === '0-100000' ? 'selected' : '' }}>$0 - $100,000</option>
                                <option value="100000-300000" {{ request('price_range') === '100000-300000' ? 'selected' : '' }}>$100,000 - $300,000</option>
                                <option value="300000-plus" {{ request('price_range') === '300000-plus' ? 'selected' : '' }}>$300,000+</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Properties Grid -->
        <div class="row g-4">
            @forelse($properties as $property)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="property-item rounded overflow-hidden shadow-sm">
                        <!-- Property Image -->
                        <div class="position-relative overflow-hidden">
                            <div id="carousel-{{ $property->id }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @forelse($property->images as $key => $image)
                                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                            <a class="d-block h5 mb-2 text-truncate" href="{{ route('client.properties.show', $property->id) }}">

                                            <img src="{{ Storage::url($image->image_path) }}"
                                                 class="d-block w-100"
                                                 alt="Property Image {{ $key + 1 }}"
                                                 style="height: 300px; object-fit: cover;">
                                            </a>
                                        </div>
                                    @empty
                                        <div class="carousel-item active">
                                            <img src="/img/default-property.jpg"
                                                 class="d-block w-100"
                                                 alt="Default Property Image"
                                                 style="height: 300px; object-fit: cover;">
                                        </div>
                                    @endforelse
                                </div>
                                @if($property->images->count() > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $property->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $property->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    </button>
                                @endif
                            </div>

                            <!-- Property Status Badge -->
                            <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">
                                {{ $property->status === 'for_sale' ? 'For Sale' : 'For Rent' }}
                            </div>

                            <!-- Property Type Badge -->
                            <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">
                                <a class="d-block h5 mb-2 text-truncate" href="{{ route('client.properties.show', $property->id) }}">

                                {{ ucfirst($property->type) }}
                                </a>
                            </div>
                        </div>

                        <!-- Property Details -->
                        <div class="p-4 pb-0">
                            <h5 class="text-primary mb-3">${{ number_format($property->price) }}</h5>
                            <a class="d-block h5 mb-2 text-truncate" href="{{ route('client.properties.show', $property->id) }}">
                                {{ $property->title }}
                            </a>
                            <p class="text-body mb-3">
                                <i class="fa fa-map-marker-alt text-primary me-2"></i>
                                {{ $property->address }}, {{ $property->city }}
                            </p>
                        </div>

                        <!-- Property Features -->
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center border-end py-2">
                                <i class="fa fa-ruler-combined text-primary me-2"></i>{{ number_format($property->square_feet) }} Sqft
                            </small>
                            <small class="flex-fill text-center border-end py-2">
                                <i class="fa fa-bed text-primary me-2"></i>{{ $property->bedrooms }} Bed
                            </small>
                            <small class="flex-fill text-center py-2">
                                <i class="fa fa-bath text-primary me-2"></i>{{ $property->bathrooms }} Bath
                            </small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="empty-state wow fadeInUp" data-wow-delay="0.1s">
                        <i class="fas fa-home fa-4x text-primary mb-4"></i>
                        <h3>No Properties Found</h3>
                        <p class="text-muted">We couldn't find any properties matching your criteria.</p>
                        <a href="{{ route('allproperties') }}" class="btn btn-primary mt-3">Clear Filters</a>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- <!-- Pagination -->
        <div class="row mt-5">
            <div class="col-12">
                @if($properties->count() > 0)
                    <div class="d-flex justify-content-center wow fadeInUp" data-wow-delay="0.1s">
                        {{ $properties->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div> --}}
<!-- Property List End -->

<style>
    /* Pagination Styles */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }

    .page-item {
        margin: 0 2px;
    }

    .page-link {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        border: 1px solid #dee2e6;
        color: #00B98E;
        background-color: #fff;
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background-color: #00B98E;
        color: #fff;
        border-color: #00B98E;
    }

    .page-item.active .page-link {
        background-color: #00B98E;
        border-color: #00B98E;
        color: #fff;
    }

    /* Property Card Hover Effects */
    .property-item {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .property-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    /* Form Controls Styling */
    .form-select {
        border-radius: 0.375rem;
        border: 1px solid #dee2e6;
        padding: 0.5rem;
    }

    .form-select:focus {
        border-color: #00B98E;
        box-shadow: 0 0 0 0.25rem rgba(0, 185, 142, 0.25);
    }

    /* Empty State Styling */
    .empty-state {
        padding: 3rem 1rem;
    }
</style>

<!-- Content end -->
@endSection
