<div {{ $attributes->merge(['class' => 'avatar-wrapper overflow-hidden ' . $attributes->get('class', 'w-10 h-10 rounded-xl md:h-11 md:w-11')]) }}>
    <div class="object-cover w-full h-full">
        {!! ARKEcosystem\UserInterface\Support\Avatar::make($identifier, $attributes->get('identifier-with-letters')) !!}
    </div>
</div>
