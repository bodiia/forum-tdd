<div class="mx-auto w-3/4 rounded-xl overflow-hidden">
    <header {{ $attributes->merge(['class' => 'h-3/4 px-8 py-2 bg-gray-800 text-white']) }}>
        {{ $header }}
    </header>

    <section class="bg-white p-6">
        {{ $body }}
    </section>
</div>
