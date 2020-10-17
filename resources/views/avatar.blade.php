<div
    x-data="{ avatarImage: '' }"
    x-init="avatarImage = createAvatar('{{ $identifier }}')"
    class="overflow-hidden {{ $class ?? 'w-12 h-12 rounded-lg md:h-16 md:w-16 md:rounded-xl' }}"
>
    <div x-html="avatarImage" class="object-cover w-full h-full"></div>
</div>
