@props(['message' => $message, 'type' => $type])

<div class="alert alert-{{ $type }} alert-dismissible" role="alert">
    <p class="mb-0">{{ $message }}</p>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>