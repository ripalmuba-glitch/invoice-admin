@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-md text-sm font-medium']) }} role="alert">
        {{ $status }}
    </div>
@endif
