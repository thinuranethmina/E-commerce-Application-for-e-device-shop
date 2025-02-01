@php
    $hour = date('H');
    $greeting = '';

    if ($hour < 12) {
        $greeting = 'Good Morning!';
    } elseif ($hour < 18) {
        $greeting = 'Good Afternoon!';
    } else {
        $greeting = 'Good Evening!';
    }
@endphp
<h3 class="greeting-text">
    {{ $greeting }}
</h3>
