@props(['current' => 1])

@php
$steps = [
    1 => ['label' => 'Jenjang', 'icon' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z'],
    2 => ['label' => 'Kategori', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
    3 => ['label' => 'Bidang', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
    4 => ['label' => 'Tanggal', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
    5 => ['label' => 'Kirim Berkas', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
];
@endphp

<div class="flex items-center justify-center mb-10">
    @foreach($steps as $num => $step)
        <div class="flex items-center {{ !$loop->last ? 'flex-1' : '' }}">
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 transition-all duration-300
                    {{ $current == $num ? 'bg-biogen-medium border-biogen-medium text-white shadow-md' :
                       ($current > $num ? 'bg-biogen-dark border-biogen-dark text-white' : 'bg-white border-gray-200 text-gray-400') }}">
                    @if($current > $num)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    @else
                        <span class="text-sm font-bold">{{ $num }}</span>
                    @endif
                </div>
                <span class="text-[11px] mt-1.5 font-semibold {{ $current == $num ? 'text-biogen-medium' : ($current > $num ? 'text-biogen-dark' : 'text-gray-400') }}">
                    {{ $step['label'] }}
                </span>
            </div>
            @if(!$loop->last)
                <div class="flex-1 h-0.5 mx-3 mt-[-14px] {{ $current > $num ? 'bg-biogen-dark' : 'bg-gray-200' }}"></div>
            @endif
        </div>
    @endforeach
</div>
