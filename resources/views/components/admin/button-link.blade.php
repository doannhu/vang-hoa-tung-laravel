@props([
    'href',
    'icon',
    'title',
    'description',
    'color' => 'cyan',
    'iconColor' => 'cyan'
])

<a href="{{ $href }}" class="block bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-all duration-300 hover:scale-105">
    <div class="flex items-center justify-center h-16 w-16 bg-{{ $iconColor }}-100 rounded-full mx-auto mb-4">
        <i class="fas {{ $icon }} text-2xl text-{{ $iconColor }}-600"></i>
    </div>
    <h2 class="text-xl font-semibold text-center text-gray-900 mb-4">{{ $title }}</h2>
    <p class="text-gray-600 text-center mb-6">{{ $description }}</p>
    <div class="text-center">
        <span class="inline-flex items-center px-4 py-2 bg-{{ $color }}-600 text-white rounded-md">
            <i class="fas fa-arrow-right mr-2"></i>
            Truy cập
        </span>
    </div>
</a> 