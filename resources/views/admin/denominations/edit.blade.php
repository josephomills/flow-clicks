@extends('layouts.admin')

@section('title', 'Edit Denomination')

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

  <form method="POST" action="{{ route('admin.denominations.update', $denomination->id) }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Column 1 -->
      <div class="space-y-6">
        <!-- Name Field -->
        <div>
          <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Name *</label>
          <input type="text" id="name" name="name" value="{{ old('name', $denomination->name) }}" required
                 class="w-full h-10 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                 placeholder="e.g. Pentecostal Church">
          @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Slug Field -->
        <div>
          <label for="slug" class="block mb-2 text-sm font-medium text-gray-700">Slug *</label>
          <input type="text" id="slug" name="slug" value="{{ old('slug', $denomination->slug) }}" required
                 class="w-full h-10 rounded-md border border-gray-300 bg-white px-3 py-2 font-mono text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                 placeholder="e.g. pentecostal-church">
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
              <input type="file" id="logo" name="logo" accept="image/*" onchange="previewLogo(event)"
                     class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm file:mr-4 file:py-1.5 file:px-4 file:rounded file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
              <p class="mt-1 text-xs text-gray-500">Recommended size: 300x300px. Max 2MB.</p>
              @error('logo')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
            <div class="mt-[28px]">
              <div id="logoPreviewContainer" class="{{ $denomination->logo ? '' : 'hidden' }}">
                <img id="logoPreview" class="h-20 w-20 rounded-md border object-contain" 
                     src="{{ $denomination->logo ? asset('storage/' . $denomination->logo) : '#' }}" 
                     alt="Current logo">
              </div>
              <div id="logoPlaceholder" class="h-20 w-20 rounded-md border border-gray-200 bg-gray-50 flex items-center justify-center {{ $denomination->logo ? 'hidden' : '' }}">
                <span class="text-xs text-gray-400">No logo</span>
              </div>
            </div>
          </div>
          @if($denomination->logo)
            <div class="mt-2 flex items-center">
              <input type="checkbox" id="remove_logo" name="remove_logo" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
              <label for="remove_logo" class="ml-2 block text-sm text-gray-700">Remove current logo</label>
            </div>
          @endif
        </div>
      </div>

      <!-- Column 2 -->
      <div class="space-y-6">
        <!-- Average Attendance -->
        <div>
          <label for="avg_attendance" class="block mb-2 text-sm font-medium text-gray-700">Average Attendance</label>
          <input type="number" id="avg_attendance" name="avg_attendance" 
                 value="{{ old('avg_attendance', $denomination->avg_attendance) }}"
                 class="w-full h-10 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                 placeholder="e.g. 5000">
          @error('avg_attendance')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Country -->
        <div>
          <label for="country" class="block mb-2 text-sm font-medium text-gray-700">Country *</label>
          <input type="text" id="country" name="country" value="{{ old('country', $denomination->country) }}" required
                 class="w-full h-10 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                 placeholder="e.g. Ghana">
          @error('country')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- City -->
        <div>
          <label for="city" class="block mb-2 text-sm font-medium text-gray-700">City *</label>
          <input type="text" id="city" name="city" value="{{ old('city', $denomination->city) }}" required
                 class="w-full h-10 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                 placeholder="e.g. Accra">
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
              <option value="{{ $zone->id }}" {{ $zone->id == old('zone_id', $denomination->zone_id) ? 'selected' : '' }}>{{ $zone->name }}</option>
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
        Update Denomination
      </button>
    </div>
  </form>
</div>

@push('scripts')
<script>
  function previewLogo(event) {
    const input = event.target;
    const previewContainer = document.getElementById('logoPreviewContainer');
    const preview = document.getElementById('logoPreview');
    const placeholder = document.getElementById('logoPlaceholder');
    const removeLogoCheckbox = document.getElementById('remove_logo');
    
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      
      reader.onload = function(e) {
        preview.src = e.target.result;
        previewContainer.classList.remove('hidden');
        placeholder.classList.add('hidden');
        if (removeLogoCheckbox) {
          removeLogoCheckbox.checked = false;
        }
      }
      
      reader.readAsDataURL(input.files[0]);
    } else {
      // If no file selected but we have an existing logo, keep showing it
      if ("{{ $denomination->logo }}") {
        previewContainer.classList.remove('hidden');
        placeholder.classList.add('hidden');
      } else {
        previewContainer.classList.add('hidden');
        placeholder.classList.remove('hidden');
      }
    }
  }

  // Generate slug from name
  document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const slug = name.toLowerCase()
      .replace(/ /g, '-')
      .replace(/[^\w-]+/g, '');
    document.getElementById('slug').value = slug;
  });

  // Handle remove logo checkbox
  @if($denomination->logo)
    document.getElementById('remove_logo').addEventListener('change', function() {
      if (this.checked) {
        document.getElementById('logoPreviewContainer').classList.add('hidden');
        document.getElementById('logoPlaceholder').classList.remove('hidden');
        document.getElementById('logo').value = '';
      } else {
        document.getElementById('logoPreviewContainer').classList.remove('hidden');
        document.getElementById('logoPlaceholder').classList.add('hidden');
      }
    });
  @endif
</script>
@endpush
@endsection