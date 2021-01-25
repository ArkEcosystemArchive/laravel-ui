<div class="avatar-wrapper overflow-hidden {{ $class ?? 'w-10 h-10 rounded-lg md:h-11 md:w-11' }}">
    <div class="object-cover w-full h-full">
        {!! ARKEcosystem\UserInterface\Support\Avatar::make($identifier) !!}
    </div>
</div>
