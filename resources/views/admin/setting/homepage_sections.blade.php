@extends('layouts.admin')
@push('title', get_phrase('Homepage Sections Management'))
@push('meta')@endpush
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.css">
    <style>
        .section-item {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            background: #fff;
            cursor: move;
            transition: all 0.3s;
        }
        .section-item:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        .section-item.dragging {
            opacity: 0.5;
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .section-actions {
            display: flex;
            gap: 10px;
        }
        .badge-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
        }
        .sortable-ghost {
            opacity: 0.4;
        }
        .form-control-color {
            width: 60px;
            height: 40px;
            cursor: pointer;
        }
    </style>
@endpush
@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Homepage Sections Management') }}
                </h4>
                <div class="d-flex gap-2">
                    <button type="button" class="btn ol-btn-primary" onclick="importArabicTranslations()" title="{{ get_phrase('Import Arabic translations from arabic.json') }}">
                        <span class="fi-rr-language"></span>
                        {{ get_phrase('Import Translations') }}
                    </button>
                    <button type="button" class="btn ol-btn-primary" data-bs-toggle="modal" data-bs-target="#addSectionModal">
                        <span class="fi-rr-plus"></span>
                        {{ get_phrase('Add New Section') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="ol-card">
                <div class="ol-card-body p-4">
                    <div class="mb-4">
                        <p class="text-muted">{{ get_phrase('Drag and drop sections to reorder them. Click edit to modify content.') }}</p>
                    </div>

                    @if(isset($current_sections) && count($current_sections) > 0)
                        <div class="mb-4">
                            <div class="alert alert-info d-flex align-items-center justify-content-between">
                                <div>
                                    <strong>{{ get_phrase('Current Website Sections') }}:</strong>
                                    <span class="ms-2">{{ count($current_sections) }} {{ get_phrase('sections available') }}</span>
                                </div>
                                <form action="{{ route('admin.homepage.section.import') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm ol-btn-primary">
                                        <i class="fi-rr-download"></i> {{ get_phrase('Import Current Sections') }}
                                    </button>
                                </form>
                            </div>
                            <div class="row g-3 mb-4">
                                @foreach($current_sections as $current)
                                    @php
                                        $exists = $sections->where('section_key', $current['key'])->first();
                                    @endphp
                                    <div class="col-md-4">
                                        <div class="card border {{ $exists ? 'border-success' : 'border-info' }}">
                                            <div class="card-body p-3">
                                                <h6 class="mb-2">
                                                    {{ $current['name'] }}
                                                    @if($exists)
                                                        <span class="badge bg-success ms-2">{{ get_phrase('Imported') }}</span>
                                                    @endif
                                                </h6>
                                                <small class="text-muted d-block mb-1"><strong>{{ get_phrase('Key') }}:</strong> {{ $current['key'] }}</small>
                                                @if(isset($current['title']))
                                                    <small class="text-muted d-block mb-1"><strong>{{ get_phrase('Title') }}:</strong> {{ Str::limit($current['title'], 40) }}</small>
                                                @endif
                                                <small class="text-muted d-block">{{ Str::limit($current['description'], 60) }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <div id="sections-list" class="sections-container">
                        @if($sections->count() == 0)
                            <div class="text-center py-5">
                                <p class="text-muted">{{ get_phrase('No sections found') }}</p>
                                <p class="text-muted small">{{ get_phrase('Click "Import Current Sections" above to import existing sections or add a new section manually.') }}</p>
                            </div>
                        @endif
                        @foreach ($sections as $section)
                            <div class="section-item" data-id="{{ $section->id }}">
                                <div class="section-header">
                                    <div>
                                        <h5 class="mb-1">
                                            <i class="fi-rr-menu-dots-vertical me-2 text-muted"></i>
                                            {{ $section->section_name }}
                                            <span class="badge badge-status {{ $section->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $section->is_active ? get_phrase('Active') : get_phrase('Inactive') }}
                                            </span>
                                        </h5>
                                        <small class="text-muted">{{ get_phrase('Key') }}: {{ $section->section_key }} | {{ get_phrase('Order') }}: {{ $section->sort_order }}</small>
                                    </div>
                                    <div class="section-actions">
                                        <button type="button" class="btn btn-sm ol-btn-primary" onclick="editSection({{ $section->id }})">
                                            <i class="fi-rr-edit"></i> {{ get_phrase('Edit') }}
                                        </button>
                                        <button type="button" class="btn btn-sm ol-btn-danger" onclick="deleteSection({{ $section->id }})">
                                            <i class="fi-rr-trash"></i> {{ get_phrase('Delete') }}
                                        </button>
                                    </div>
                                </div>
                                @if($section->title)
                                    <div class="mb-2">
                                        <strong>{{ get_phrase('Title') }}:</strong> {{ $section->title }}
                                    </div>
                                @endif
                                @if($section->subtitle)
                                    <div class="mb-2">
                                        <strong>{{ get_phrase('Subtitle') }}:</strong> {{ $section->subtitle }}
                                    </div>
                                @endif
                                @if($section->description)
                                    <div class="mb-2">
                                        <strong>{{ get_phrase('Description') }}:</strong> {{ Str::limit($section->description, 100) }}
                                    </div>
                                @endif
                                @if($section->image)
                                    <div class="mb-2">
                                        <strong>{{ get_phrase('Image') }}:</strong>
                                        <img src="{{ asset($section->image) }}" alt="" class="img-thumbnail ms-2" style="max-width: 100px; max-height: 100px;">
                                    </div>
                                @endif
                                @if($section->video_url)
                                    <div class="mb-2">
                                        <strong>{{ get_phrase('Video') }}:</strong>
                                        <a href="{{ $section->video_url }}" target="_blank" class="ms-2">{{ Str::limit($section->video_url, 50) }}</a>
                                    </div>
                                @endif
                                @if($section->design_type)
                                    <div class="mb-2">
                                        <strong>{{ get_phrase('Design Type') }}:</strong>
                                        <span class="badge bg-info ms-2">{{ $section->design_type }}</span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    @if($sections->count() > 0)
                        <div class="mt-4">
                            <button type="button" class="btn ol-btn-primary" onclick="saveSortOrder()">
                                <i class="fi-rr-check"></i> {{ get_phrase('Save Order') }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Section Modal -->
    <div class="modal fade" id="addSectionModal" tabindex="-1" aria-labelledby="addSectionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSectionModalLabel">{{ get_phrase('Add New Section') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.homepage.section.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">{{ get_phrase('Section Key') }} <span class="text-danger">*</span></label>
                            <input type="text" name="section_key" class="form-control" required placeholder="e.g., banner, hero, courses">
                            <small class="text-muted">{{ get_phrase('Unique identifier for this section (lowercase, no spaces)') }}</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ get_phrase('Section Name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="section_name" class="form-control" required placeholder="e.g., Banner Section">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ get_phrase('Design Type') }}</label>
                            <select name="design_type" class="form-control" id="add_design_type">
                                <option value="default">{{ get_phrase('Default') }}</option>
                                <option value="image_left">{{ get_phrase('Image Left') }}</option>
                                <option value="image_right">{{ get_phrase('Image Right') }}</option>
                                <option value="full_width">{{ get_phrase('Full Width') }}</option>
                                <option value="grid">{{ get_phrase('Grid') }}</option>
                                <option value="centered">{{ get_phrase('Centered') }}</option>
                                <option value="split">{{ get_phrase('Split Layout') }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ get_phrase('Image') }}</label>
                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this, 'add_image_preview')">
                            <small class="text-muted">{{ get_phrase('Upload section image (Max: 5MB)') }}</small>
                            <div id="add_image_preview" class="mt-2"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ get_phrase('Video URL') }}</label>
                            <input type="url" name="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                            <small class="text-muted">{{ get_phrase('YouTube, Vimeo, or direct video URL') }}</small>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ get_phrase('Background Color') }}</label>
                                <input type="color" name="background_color" class="form-control form-control-color" value="#ffffff">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ get_phrase('Text Color') }}</label>
                                <input type="color" name="text_color" class="form-control form-control-color" value="#000000">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ get_phrase('Title') }}</label>
                            <input type="text" name="title" class="form-control" placeholder="Section title">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ get_phrase('Subtitle') }}</label>
                            <input type="text" name="subtitle" class="form-control" placeholder="Section subtitle">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ get_phrase('Description') }}</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Section description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ get_phrase('Content') }}</label>
                            <textarea name="content" class="form-control text_editor" rows="5" placeholder="HTML content"></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                                <label class="form-check-label" for="is_active">
                                    {{ get_phrase('Active') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ get_phrase('Cancel') }}</button>
                        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Add Section') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Section Modal -->
    <div class="modal fade" id="editSectionModal" tabindex="-1" aria-labelledby="editSectionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSectionModalLabel">{{ get_phrase('Edit Section') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editSectionForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">{{ get_phrase('Section Key') }} <span class="text-danger">*</span></label>
                            <input type="text" name="section_key" id="edit_section_key" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ get_phrase('Section Name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="section_name" id="edit_section_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ get_phrase('Design Type') }}</label>
                            <select name="design_type" class="form-control" id="edit_design_type">
                                <option value="default">{{ get_phrase('Default') }}</option>
                                <option value="image_left">{{ get_phrase('Image Left') }}</option>
                                <option value="image_right">{{ get_phrase('Image Right') }}</option>
                                <option value="full_width">{{ get_phrase('Full Width') }}</option>
                                <option value="grid">{{ get_phrase('Grid') }}</option>
                                <option value="centered">{{ get_phrase('Centered') }}</option>
                                <option value="split">{{ get_phrase('Split Layout') }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ get_phrase('Image') }}</label>
                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this, 'edit_image_preview')">
                            <small class="text-muted">{{ get_phrase('Upload section image (Max: 5MB)') }}</small>
                            <div id="edit_image_preview" class="mt-2"></div>
                            <div id="edit_current_image" class="mt-2"></div>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="delete_image" id="edit_delete_image" value="1">
                                <label class="form-check-label text-danger" for="edit_delete_image">
                                    {{ get_phrase('Delete current image') }}
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ get_phrase('Video URL') }}</label>
                            <input type="url" name="video_url" id="edit_video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                            <small class="text-muted">{{ get_phrase('YouTube, Vimeo, or direct video URL') }}</small>
                            <div id="edit_video_preview" class="mt-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ get_phrase('Background Color') }}</label>
                                <input type="color" name="background_color" id="edit_background_color" class="form-control form-control-color" value="#ffffff">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ get_phrase('Text Color') }}</label>
                                <input type="color" name="text_color" id="edit_text_color" class="form-control form-control-color" value="#000000">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ get_phrase('Title') }}</label>
                            <input type="text" name="title" id="edit_title" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ get_phrase('Subtitle') }}</label>
                            <input type="text" name="subtitle" id="edit_subtitle" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ get_phrase('Description') }}</label>
                            <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ get_phrase('Content') }}</label>
                            <textarea name="content" id="edit_content" class="form-control text_editor" rows="5"></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" id="edit_is_active">
                                <label class="form-check-label" for="edit_is_active">
                                    {{ get_phrase('Active') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ get_phrase('Cancel') }}</button>
                        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Update Section') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        "use strict";
        
        // Initialize Sortable
        let sortable = null;
        document.addEventListener('DOMContentLoaded', function() {
            const sectionsList = document.getElementById('sections-list');
            if (sectionsList) {
                sortable = new Sortable(sectionsList, {
                    animation: 150,
                    handle: '.section-item',
                    ghostClass: 'sortable-ghost',
                    onEnd: function(evt) {
                        // Visual feedback
                    }
                });
            }
        });

        // Save sort order
        function saveSortOrder() {
            const items = document.querySelectorAll('#sections-list .section-item');
            const itemArray = [];
            
            items.forEach(function(item) {
                itemArray.push(item.getAttribute('data-id'));
            });

            $.ajax({
                url: "{{ route('admin.homepage.section.sort') }}",
                type: 'POST',
                data: {
                    itemJSON: JSON.stringify(itemArray),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    success(get_phrase('Sections sorted successfully'));
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                },
                error: function() {
                    error(get_phrase('Failed to save order'));
                }
            });
        }

        // Preview image
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + previewId).html('<img src="' + e.target.result + '" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Preview video
        function previewVideo(url, previewId) {
            if (url) {
                var embedUrl = '';
                if (url.includes('youtube.com') || url.includes('youtu.be')) {
                    var videoId = '';
                    if (url.includes('youtube.com/watch?v=')) {
                        videoId = url.split('v=')[1].split('&')[0];
                    } else if (url.includes('youtu.be/')) {
                        videoId = url.split('youtu.be/')[1].split('?')[0];
                    }
                    embedUrl = 'https://www.youtube.com/embed/' + videoId;
                } else if (url.includes('vimeo.com')) {
                    var videoId = url.split('vimeo.com/')[1].split('?')[0];
                    embedUrl = 'https://player.vimeo.com/video/' + videoId;
                }
                
                if (embedUrl) {
                    $('#' + previewId).html('<div class="ratio ratio-16x9"><iframe src="' + embedUrl + '" frameborder="0" allowfullscreen></iframe></div>');
                } else {
                    $('#' + previewId).html('<video controls class="w-100" style="max-height: 300px;"><source src="' + url + '" type="video/mp4"></video>');
                }
            }
        }

        // Edit section
        function editSection(id) {
            $.ajax({
                url: "{{ route('admin.homepage.section.show', '') }}/" + id,
                type: 'GET',
                success: function(response) {
                    $('#edit_section_key').val(response.section_key);
                    $('#edit_section_name').val(response.section_name);
                    $('#edit_design_type').val(response.design_type || 'default');
                    $('#edit_title').val(response.title || '');
                    $('#edit_subtitle').val(response.subtitle || '');
                    $('#edit_description').val(response.description || '');
                    $('#edit_content').val(response.content || '');
                    $('#edit_video_url').val(response.video_url || '');
                    $('#edit_background_color').val(response.background_color || '#ffffff');
                    $('#edit_text_color').val(response.text_color || '#000000');
                    $('#edit_is_active').prop('checked', response.is_active == 1);
                    
                    // Show current image
                    if (response.image) {
                        $('#edit_current_image').html('<p class="text-muted small">Current Image:</p><img src="{{ asset("") }}' + response.image + '" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">');
                    } else {
                        $('#edit_current_image').html('');
                    }
                    
                    // Preview video if exists
                    if (response.video_url) {
                        previewVideo(response.video_url, 'edit_video_preview');
                    } else {
                        $('#edit_video_preview').html('');
                    }
                    
                    $('#editSectionForm').attr('action', "{{ route('admin.homepage.section.update', '') }}/" + id);
                    $('#editSectionModal').modal('show');
                    
                    // Preview video on URL change
                    $('#edit_video_url').off('change').on('change', function() {
                        var url = $(this).val();
                        if (url) {
                            previewVideo(url, 'edit_video_preview');
                        } else {
                            $('#edit_video_preview').html('');
                        }
                    });
                }
            });
        }

        // Delete section
        function deleteSection(id) {
            if (confirm(get_phrase('Are you sure?') + '\n' + get_phrase("You can't bring it back!"))) {
                window.location.href = "{{ route('admin.homepage.section.delete', '') }}/" + id;
            }
        }

        // Import Arabic translations
        function importArabicTranslations() {
            if (confirm('{{ get_phrase("Are you sure you want to import Arabic translations from arabic.json?") }}')) {
                $.ajax({
                    url: "{{ route('admin.import.arabic.translations') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        success(response.message || '{{ get_phrase("Translations imported successfully") }}');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    },
                    error: function(xhr) {
                        var message = xhr.responseJSON?.error || '{{ get_phrase("Failed to import translations") }}';
                        error(message);
                    }
                });
            }
        }
    </script>
@endpush
