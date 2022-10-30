@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-800 focus:border-gray-500 focus:ring focus:ring-gray-200 focus:ring-opacity-50']) !!}>
