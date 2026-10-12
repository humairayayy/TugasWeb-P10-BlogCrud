@props(['type' => 'success'])

<div {{ $attributes->merge(['class' => "alert alert-$type alert-dismissible fade show"]) }} role="alert">
    {{ $slot }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>