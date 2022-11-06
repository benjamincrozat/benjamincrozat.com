@if (! empty($banner))
    <div {{ $attributes->merge(['class' => 'border dark:border-gray-800 rounded']) }}>
        <div class="border-b dark:border-gray-800 flex items-center justify-center gap-2 font-normal leading-tight p-2 text-indigo-400">
            <x-heroicon-o-information-circle class="-translate-y-[.5px] flex-shrink-0 w-4 h-5 h-4" />
            {{ $banner->title }}
        </div>

        <div class="grid place-items-center gap-4 p-4">
            <div class="flex items-center justify-center gap-4 sm:gap-6 md:gap-8 md:max-w-screen-sm md:mx-auto">
                @if (false || $banner->image)
                    <img src="{{ str_replace('w_auto', 'h_80', $banner->image) }}" width="64" height="64" alt="{{ $banner->affiliate->name }}" class="order-1 rounded-lg" />
                @endif

                <div>
                    {!! Illuminate\Support\Str::lightdown($banner->content) !!}
                </div>
            </div>

            <p class="mt-4">
                <a
                    href="{{ route('affiliate', $banner->affiliate) }}"
                    class="bg-gradient-to-r from-indigo-300 dark:from-indigo-500 to-indigo-400 dark:to-indigo-600 block leading-tight sm:max-w-screen-xs mx-auto px-4 py-3 rounded shadow-md text-center text-green-50"
                    @click="window.fathom?.trackGoal('K8DBWLRF', 0)"
                >
                    {!! Illuminate\Support\Str::lightdown($banner->button) !!}
                </a>
            </p>
        </div>
    </div>
@endif
