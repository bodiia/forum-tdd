<div class="rounded-md overflow-hidden">
    <header {{ $attributes->merge(['class' => 'h-3/4 px-8 py-2 bg-gray-800 text-white text-lg']) }}>
        {{ $header }}
    </header>

    <section class="rounded-b-md bg-white p-6 border border-gray-800">
        {{ $body }}
    </section>
</div>
