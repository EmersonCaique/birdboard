@if ($errors->{ $bag ?? 'default'}->any())
    <ul class="mt-3">
        @foreach ($errors->{ $bag ?? 'default' }->all() as $error)
            <li class="text-sm"> {{ $error }}</li>
        @endforeach
    </ul>
@endif
