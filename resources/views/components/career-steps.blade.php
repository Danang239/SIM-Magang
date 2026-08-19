@props(['current' => 1])

@php
$steps = [
    1 => ['label' => 'Tanggal & Durasi', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
    2 => ['label' => 'Biodata & Kirim Berkas', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
];
@endphp

<div class="flex items-center justify-center mb-10 max-w-md mx-auto">
    @foreach($steps as $num => $step)
        <div class="flex items-center {{ !$loop->last ? 'flex-1' : '' }}">
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 transition-all duration-300
                    {{ $current == $num ? 'bg-emerald-600 border-emerald-600 text-white shadow-md' :
                       ($current > $num ? 'bg-emerald-800 border-emerald-800 text-white' : 'bg-white border-gray-200 text-gray-400') }}">
                    @if($current > $num)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    @else
                        <span class="text-sm font-bold">{{ $num }}</span>
                    @endif
                </div>
                <span class="text-[11px] mt-1.5 font-bold whitespace-nowrap {{ $current == $num ? 'text-emerald-600' : ($current > $num ? 'text-emerald-800' : 'text-gray-400') }}">
                    {{ $step['label'] }}
                </span>
            </div>
            @if(!$loop->last)
                <div class="flex-1 h-0.5 mx-3 mt-[-18px] {{ $current > $num ? 'bg-emerald-800' : 'bg-gray-200' }}"></div>
            @endif
        </div>
    @endforeach
</div>
