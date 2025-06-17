@extends('layouts.admin')

@section('title', 'Add Denomination')

@section('top-action')
<a class="flex flex-row items-center text-sm bg-primary text-primary-foreground py-3 px-4 rounded-md text-center hover:bg-primary/90" href="{{ route('admin.denominations') }}">
  <x-heroicon-s-arrow-left class="mr-1 h-5 w-5" />
  Go Back
</a>
@endsection

@section('content')
<div class="bg-background rounded-md border p-6">
  @if (session('success'))
    <x-alert type="success">
      {{ session('success') }}
    </x-alert>
  @elseif (session('error'))
    <x-alert type="danger">
      {{ session('error') }}
    </x-alert>
  @endif

  <form method="post" action="{{ route('admin.denominations.store') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Column 1 -->
      <div class="space-y-6">
        <!-- Name Field -->
        <div>
          <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Name *</label>
          <input type="text" id="name" name="name" required
                 class="w-full h-10 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                 placeholder="e.g. Pentecostal Church"
                 value="{{ old('name') }}">
          @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Slug Field -->
        <div>
          <label for="slug" class="block mb-2 text-sm font-medium text-gray-700">Slug *</label>
          <input type="text" id="slug" name="slug" required
                 class="w-full h-10 rounded-md border border-gray-300 bg-white px-3 py-2 font-mono text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                 placeholder="e.g. pentecostal-church"
                 value="{{ old('slug') }}">
          <p class="mt-1 text-xs text-gray-500">URL-friendly identifier. Must be unique.</p>
          @error('slug')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Logo Upload with Preview -->
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Logo</label>
          <div class="flex items-start gap-4">
            <div class="flex-1">
              <input type="file" id="logo" name="logo" accept="image/*"
                     class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm file:mr-4 file:py-1.5 file:px-4 file:rounded file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
              <p class="mt-1 text-xs text-gray-500">Recommended size: 300x300px. Max 2MB.</p>
              @error('logo')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
            <div class="flex-shrink-0">
              <div id="logoPreviewContainer" class="hidden">
                <img id="logoPreview" class="h-20 w-20 rounded-md border object-cover bg-white" src="#" alt="Logo preview">
              </div>
              <div id="logoPlaceholder" class="h-20 w-20 rounded-md border border-gray-200 bg-gray-50 flex items-center justify-center">
                <span class="text-xs text-gray-400 text-center px-1">No logo</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Column 2 -->
      <div class="space-y-6">
        <!-- Average Attendance -->
        <div>
          <label for="avg_attendance" class="block mb-2 text-sm font-medium text-gray-700">Average Attendance</label>
          <input type="number" id="avg_attendance" name="avg_attendance"
                 class="w-full h-10 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                 placeholder="e.g. 5000"
                 value="{{ old('avg_attendance') }}">
          @error('avg_attendance')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Country -->
        <div>
          <label for="country" class="block mb-2 text-sm font-medium text-gray-700">Country *</label>
          <input type="text" id="country" name="country" required
                 class="w-full h-10 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                 placeholder="e.g. Ghana"
                 value="{{ old('country') }}">
          @error('country')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- City -->
        <div>
          <label for="city" class="block mb-2 text-sm font-medium text-gray-700">City *</label>
          <input type="text" id="city" name="city" required
                 class="w-full h-10 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                 placeholder="e.g. Accra"
                 value="{{ old('city') }}">
          @error('city')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Zone -->
        <div>
          <label for="zone_id" class="block mb-2 text-sm font-medium text-gray-700">Zone *</label>
          <select id="zone_id" name="zone_id" required
                  class="w-full h-10 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
            <option value="">Select a zone</option>
            @foreach($zones as $zone)
              <option value="{{ $zone->id }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>{{ $zone->name }}</option>
            @endforeach
          </select>
          @error('zone_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>
      </div>
    </div>

    <!-- Form Actions -->
    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
      <a href="{{ route('admin.denominations') }}" class="flex items-center px-4 py-2 rounded-md border border-gray-300 text-sm font-medium hover:bg-gray-50">
        Cancel
      </a>
      <button type="submit" class="flex items-center bg-primary text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-primary/90">
        Save Denomination
      </button>
    </div>
  </form>
</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const logoInput = document.getElementById('logo');
    const previewContainer = document.getElementById('logoPreviewContainer');
    const preview = document.getElementById('logoPreview');
    const placeholder = document.getElementById('logoPlaceholder');
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');

    // Logo preview functionality
    function previewLogo(event) {
      const input = event.target;
      
      if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validate file type
        if (!file.type.startsWith('image/')) {
          alert('Please select a valid image file.');
          input.value = '';
          return;
        }
        
        // Validate file size (2MB max)
        if (file.size > 2 * 1024 * 1024) {
          alert('File size must be less than 2MB.');
          input.value = '';
          return;
        }
        
        const reader = new FileReader();
        
        reader.onload = function(e) {
          preview.src = e.target.result;
          previewContainer.classList.remove('hidden');
          placeholder.classList.add('hidden');
        };
        
        reader.onerror = function() {
          alert('Error reading file. Please try again.');
          resetPreview();
        };
        
        reader.readAsDataURL(file);
      } else {
        resetPreview();
      }
    }

    function resetPreview() {
      previewContainer.classList.add('hidden');
      placeholder.classList.remove('hidden');
      preview.src = '#';
    }

    // Generate slug from name
    function generateSlug() {
      const name = nameInput.value.trim();
      const slug = name.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '') // Remove special characters except spaces and hyphens
        .replace(/\s+/g, '-') // Replace spaces with hyphens
        .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
        .replace(/^-|-$/g, ''); // Remove leading/trailing hyphens
      
      slugInput.value = slug;
    }

    // Event listeners
    logoInput.addEventListener('change', previewLogo);
    nameInput.addEventListener('input', generateSlug);
  });
</script>
@endpush
@endsection