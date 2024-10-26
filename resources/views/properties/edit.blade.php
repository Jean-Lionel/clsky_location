@extends('layouts.admin')
{{-- Dans resources/views/properties/edit.blade.php --}}
@push('styles')
<style>
.sortable-ghost {
    opacity: 0.5;
    background: #c8ebfb;
}

.property-image {
    cursor: move;
    transition: transform 0.2s;
}

.property-image:hover {
    transform: scale(1.05);
}
</style>
@endpush

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Gestion des images</h5>
    </div>
    <div class="card-body">
        <!-- Upload Zone -->
        <div class="upload-zone mb-4 p-4 text-center border-2 border-dashed rounded" 
             id="dropZone">
            <i class="bi bi-cloud-upload fs-1 text-primary"></i>
            <p class="mb-2">Glissez vos images ici ou</p>
            <input type="file" 
                   id="imageInput" 
                   multiple 
                   accept="image/*" 
                   class="d-none">
            <button type="button" 
                    class="btn btn-primary" 
                    onclick="document.getElementById('imageInput').click()">
                Sélectionnez des fichiers
            </button>
        </div>

        <!-- Preview & Sorting Zone -->
        <div class="row g-3" id="imageList">
            @foreach($property->images as $image)
                <div class="col-md-3" data-id="{{ $image->id }}">
                    <div class="card property-image">
                        <img src="{{ Storage::url($image->image_path) }}" 
                             class="card-img-top" 
                             alt="Image {{ $loop->iteration }}">
                        <div class="card-body p-2">
                            <div class="btn-group w-100">
                                @if(!$image->is_primary)
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-primary" 
                                            onclick="setPrimaryImage({{ $image->id }})">
                                        <i class="bi bi-star"></i>
                                    </button>
                                @endif
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger" 
                                        onclick="deleteImage({{ $image->id }})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                        @if($image->is_primary)
                            <div class="position-absolute top-0 start-0 p-2">
                                <span class="badge bg-primary">
                                    <i class="bi bi-star-fill"></i> Principal
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script>

document.addEventListener('DOMContentLoaded', function() {
    // Configuration Sortable.js pour le drag & drop
    const imageList = document.getElementById('imageList');
    if (imageList) {
        new Sortable(imageList, {
            animation: 150,
            ghostClass: 'bg-light',
            onEnd: function(evt) {
                const imageIds = [...evt.to.children].map(el => el.dataset.id);
                updateImageOrder(imageIds);
            }
        });
    }

    // Fonction pour mettre à jour l'ordre des images
    function updateImageOrder(imageIds) {
        fetch('{{ route('properties.update-image-order', $property) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ imageIds })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert('Erreur lors de la mise à jour de l\'ordre des images');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue');
        });
    }
new Sortable(document.getElementById('imageList'), {
    animation: 150,
    ghostClass: 'sortable-ghost',
    onEnd: function(evt) {
        const imageIds = [...evt.to.children].map(el => el.dataset.id);
        updateImageOrder(imageIds);
    }
});

// Drag & Drop Upload
const dropZone = document.getElementById('dropZone');
const imageInput = document.getElementById('imageInput');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    dropZone.classList.add('bg-light');
}

function unhighlight(e) {
    dropZone.classList.remove('bg-light');
}

dropZone.addEventListener('drop', handleDrop, false);
imageInput.addEventListener('change', handleFiles, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    handleFiles({target: {files}});
}

function handleFiles(e) {
    const files = [...e.target.files];
    uploadFiles(files);
}

function uploadFiles(files) {
    const formData = new FormData();
    files.forEach(file => formData.append('images[]', file));
    
    // Ajouter le token CSRF
    formData.append('_token', '{{ csrf_token() }}');

    fetch('{{ route('properties.upload-images', $property) }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            alert(data.message || 'Une erreur est survenue');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Une erreur est survenue lors du téléchargement');
    });
}

function updateImageOrder(imageIds) {
    fetch('{{ route('properties.update-image-order', $property) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ imageIds })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert('Erreur lors de la mise à jour de l\'ordre des images');
        }
    });
}
</script>
@endpush

