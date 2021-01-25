<div class="avatar-wrapper overflow-hidden {{ $class ?? 'w-12 h-12 rounded-lg md:h-16 md:w-16 md:rounded-xl' }}">
    <div class="object-cover w-full h-full">
        {!! ARKEcosystem\UserInterface\Support\Avatar::make($identifier) !!}
    </div>
</div>