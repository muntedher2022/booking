@php
    header("Location: " . route('otp.verify'));
    exit;
@endphp
<script>
    window.location.href = "{{ route('otp.verify') }}";
</script>
