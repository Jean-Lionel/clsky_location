<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-0 gx-5 align-items-end">
            <div class="col-lg-6">
                <div class="text-start mx-auto mb-5 wow slideInLeft" data-wow-delay="0.1s">
                    <h1 class="mb-3">Property Listing</h1>
                    <p>Find your dream property from our carefully curated listings.</p>
                </div>
            </div>
            <div class="col-lg-6 text-start text-lg-end wow slideInRight" data-wow-delay="0.1s">
                <ul class="nav nav-pills d-inline-flex justify-content-end mb-5">
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-primary {{ !request('status') ? 'active' : '' }}" href="{{ request()->url() }}">All</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-primary {{ request('status') === 'for_sale' ? 'active' : '' }}"
                           href="{{ request()->fullUrlWithQuery(['status' => 'for_sale']) }}">For Sale</a>
                    </li>
                    <li class="nav-item me-0">
                        <a class="btn btn-outline-primary {{ request('status') === 'for_rent' ? 'active' : '' }}"
                           href="{{ request()->fullUrlWithQuery(['status' => 'for_rent']) }}">For Rent</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <div id="tab-1" class="tab-pane fade show p-0 active">
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
                                {{ ucfirst($property->type) }}
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
                        <a href="{{ route('properties.index') }}" class="btn btn-primary mt-3">Clear Filters</a>
                    </div>
                </div>
            @endforelse

                    {{-- @if($properties->count() > 0)
                        <div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">
                            {{ $properties->links() }}
                        </div>
                    @endif --}}
                    <div class="col-12 text-center">
                        <a class="btn btn-primary py-3 px-5" href="{{ route('client.properties.index') }}">Browse More Property</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
