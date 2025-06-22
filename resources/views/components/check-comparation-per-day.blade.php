@props(['todayValue', 'yesterdayValue'])

@php
    $comparationValue = $todayValue - $yesterdayValue;
@endphp

@if ($comparationValue >= 0)
    <span class="d-inline-flex align-items-center">
        <i class="bx bx-up-arrow-alt text-success me-1"></i>
        <span class="text-success">{{ number_format($comparationValue, 0, ',', '.') }}</span>
    </span>
@else
    <span class="d-inline-flex align-items-center">
        <i class="bx bx-down-arrow-alt text-danger me-1"></i>
        <span class="text-danger">{{ number_format($comparationValue, 0, ',', '.') }}</span>
    </span>
@endif
