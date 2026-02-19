@extends('layouts.admin')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Breadcrumb -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">{{ __(@$title) }}</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.course.index') }}">{{ __('Courses') }}</a></li>
                                    <li class="breadcrumb-item active">{{ __('Add Course') }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.course.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <!-- Basic Information -->
                                    <div class="col-md-12">
                                        <h5 class="mb-3">Basic Information</h5>
                                    </div>

                                    <!-- Title -->
                                    <div class="col-md-12 mb-3">
                                        <label for="title" class="form-label">Course Title <span class="text-danger">*</span></label>
                                        <input type="text"
                                               name="title"
                                               id="title"
                                               class="form-control @error('title') is-invalid @enderror"
                                               value="{{ old('title') }}"
                                               placeholder="Enter course title"
                                               required>
                                        @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Subtitle -->
                                    <div class="col-md-12 mb-3">
                                        <label for="subtitle" class="form-label">Subtitle</label>
                                        <input type="text"
                                               name="subtitle"
                                               id="subtitle"
                                               class="form-control @error('subtitle') is-invalid @enderror"
                                               value="{{ old('subtitle') }}"
                                               placeholder="Enter course subtitle">
                                        @error('subtitle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Description -->
                                    <div class="col-md-12 mb-3">
                                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                        <textarea name="description"
                                                  id="description"
                                                  class="form-control @error('description') is-invalid @enderror"
                                                  rows="5"
                                                  placeholder="Enter course description"
                                                  required>{{ old('description') }}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Feature Details -->
                                    <div class="col-md-12 mb-3">
                                        <label for="feature_details" class="form-label">Feature Details</label>
                                        <textarea name="feature_details"
                                                  id="feature_details"
                                                  class="form-control @error('feature_details') is-invalid @enderror"
                                                  rows="3"
                                                  placeholder="Enter course features (comma separated)">{{ old('feature_details') }}</textarea>
                                        @error('feature_details')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Instructor -->
                                    <div class="col-md-6 mb-3">
                                        <label for="instructor_id" class="form-label">Instructor</label>
                                        <select name="instructor_id" id="instructor_id" class="form-control @error('instructor_id') is-invalid @enderror">
                                            <option value="">{{ __('Select Instructor') }}</option>
                                            @foreach($instructors as $instructor)
                                                <option value="{{ $instructor->id }}" {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                                    {{ $instructor->first_name }} ({{ $instructor->last_name }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('instructor_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Pricing Section -->
                                    <div class="col-md-12">
                                        <h5 class="mb-3 mt-3">Pricing</h5>
                                    </div>

                                    <!-- Accessibility -->
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Course Accessibility <span class="text-danger">*</span></label>
                                        <div class="d-flex gap-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="learner_accessibility" id="paid" value="paid"
                                                       {{ old('learner_accessibility', 'paid') == 'paid' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="paid">Paid</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="learner_accessibility" id="free" value="free"
                                                       {{ old('learner_accessibility') == 'free' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="free">Free</label>
                                            </div>
                                        </div>
                                        @error('learner_accessibility')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Price -->
                                    <div class="col-md-6 mb-3" id="price_field">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="number" step="0.01" min="0"
                                               name="price"
                                               id="price"
                                               class="form-control @error('price') is-invalid @enderror"
                                               value="{{ old('price', 0) }}"
                                               placeholder="0.00">
                                        @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Old Price -->
                                    <div class="col-md-6 mb-3" id="old_price_field">
                                        <label for="old_price" class="form-label">Old Price</label>
                                        <input type="number" step="0.01" min="0"
                                               name="old_price"
                                               id="old_price"
                                               class="form-control @error('old_price') is-invalid @enderror"
                                               value="{{ old('old_price') }}"
                                               placeholder="0.00">
                                        @error('old_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Image -->
                                    <div class="col-md-12">
                                        <h5 class="mb-3 mt-3">Media</h5>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="image" class="form-label">Course Image</label>
                                        <input type="file"
                                               name="image"
                                               id="image"
                                               class="form-control @error('image') is-invalid @enderror"
                                               accept="image/*">
                                        <small class="text-muted">Accepted: JPG, PNG, GIF (Max: 2MB)</small>
                                        @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div id="imagePreview" class="mt-2"></div>
                                    </div>

                                    <!-- SEO -->
                                    <div class="col-md-12">
                                        <h5 class="mb-3 mt-3">SEO Settings</h5>
                                    </div>

                                    <!-- Meta Title -->
                                    <div class="col-md-12 mb-3">
                                        <label for="meta_title" class="form-label">Meta Title</label>
                                        <input type="text"
                                               name="meta_title"
                                               id="meta_title"
                                               class="form-control @error('meta_title') is-invalid @enderror"
                                               value="{{ old('meta_title') }}"
                                               placeholder="SEO Title">
                                        @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Meta Description -->
                                    <div class="col-md-12 mb-3">
                                        <label for="meta_description" class="form-label">Meta Description</label>
                                        <textarea name="meta_description"
                                                  id="meta_description"
                                                  class="form-control @error('meta_description') is-invalid @enderror"
                                                  rows="2"
                                                  placeholder="SEO Description">{{ old('meta_description') }}</textarea>
                                        @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Meta Keywords -->
                                    <div class="col-md-12 mb-3">
                                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                        <input type="text"
                                               name="meta_keywords"
                                               id="meta_keywords"
                                               class="form-control @error('meta_keywords') is-invalid @enderror"
                                               value="{{ old('meta_keywords') }}"
                                               placeholder="php, web development, backend">
                                        <small class="text-muted">Comma separated keywords</small>
                                        @error('meta_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- OG Image -->
                                    <div class="col-md-6 mb-3">
                                        <label for="og_image" class="form-label">OG Image (Social Media)</label>
                                        <input type="file"
                                               name="og_image"
                                               id="og_image"
                                               class="form-control @error('og_image') is-invalid @enderror"
                                               accept="image/*">
                                        <small class="text-muted">Recommended size: 1200x630 (Max: 1MB)</small>
                                        @error('og_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-12">
                                        <h5 class="mb-3 mt-3">Status</h5>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Course Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Pending</option>
                                            <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Published</option>
                                            <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Waiting for Review</option>
                                            <option value="3" {{ old('status') == '3' ? 'selected' : '' }}>Hold</option>
                                            <option value="4" {{ old('status') == '4' ? 'selected' : '' }}>Draft</option>
                                        </select>
                                        @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Submit Buttons -->
                                    <div class="col-md-12 mt-4">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <a href="{{ route('admin.course.index') }}" class="btn btn-secondary">
                                                <i class="fas fa-times"></i> Cancel
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Save Course
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            $(document).ready(function() {
                // Toggle price fields based on accessibility
                $('input[name="learner_accessibility"]').on('change', function() {
                    if($(this).val() == 'free') {
                        $('#price_field').hide();
                        $('#old_price_field').hide();
                    } else {
                        $('#price_field').show();
                        $('#old_price_field').show();
                    }
                });

                // Image preview
                $('input[name="image"]').on('change', function() {
                    var input = this;
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('#imagePreview').html('<img src="'+e.target.result+'" style="max-width: 200px; max-height: 200px; border-radius: 5px; border: 1px solid #ddd; padding: 5px;" alt="Preview">');
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                });

                // Initialize based on old values
                @if(old('learner_accessibility') == 'free')
                $('#price_field').hide();
                $('#old_price_field').hide();
                @endif
            });
        </script>
    @endpush
@endsection