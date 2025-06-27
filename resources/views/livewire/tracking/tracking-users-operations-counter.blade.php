@php
    $colors = [
        'primary', 'success', 'danger', 'warning', 'info', 'secondary', 'dark'
    ];
    $colorCount = count($colors);
@endphp
<div wire:poll.1s="updateTrackingUsersOperationsCounter" class="w-75">
    <div class="d-flex justify-content-evenly align-items-center flex-wrap">
        @foreach ($usersDailyCounts as $idx => $User)
            @php
                $color = $colors[$loop->index % $colorCount];
            @endphp
            <button type="button" class="btn btn-{{ $color }} text-nowrap d-inline-flex position-relative me-4 mb-2">
                {{ \App\Models\User::find($User->user_id)->name ?? '---' }}
                <span class="position-absolute top-0 start-100 translate-middle btn btn-icon btn-sm btn-light btn-fab demo waves-effect waves-light py-0 px-1 number fs-4">
                    {{ $User->daily_count }}
                </span>
            </button>
        @endforeach
    </div>
</div>
