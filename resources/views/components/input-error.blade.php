@props(['messages' => $messages])

@if ($messages)
    @foreach ((array) $messages as $message)
        <div class="text-danger ms-2">{{ $message }}</div>
    @endforeach
@endif