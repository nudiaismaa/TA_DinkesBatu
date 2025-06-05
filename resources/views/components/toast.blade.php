<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast {{ $status === 'success' ? 'toast-success' : 'toast-error' }}" role="alert" aria-live="polite"
        aria-atomic="true" data-bs-delay="4000">
        <div class="toast-header">
            <strong class="me-auto">{{ $title }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ $slot }}
        </div>
    </div>
</div>
