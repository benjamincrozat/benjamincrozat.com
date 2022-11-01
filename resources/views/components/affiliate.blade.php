<aside {{ $attributes->merge(['class' => 'border p-4 rounded']) }}>
    @if ($name === 'cloudways')
        <a href="{{ route('affiliate', 'cloudways') }}?chan={{ $channel }}" target="_blank" rel="nofollow noopener noreferrer">
            <x-icon-cloudways class="flex-shrink-0 w-12 h-12" />
        </a>

        <div>
            <p>
                <strong class="font-bold">Cloudways</strong> provides <strong class="font-bold">affordable</strong>, <strong class="font-bold">easy-to-use</strong>, and <strong class="font-bold">scalable</strong> web hosting for PHP developers.
            </p>

            <p class="mt-2">
                <a href="{{ route('affiliate', 'cloudways') }}?chan={{ $channel }}" target="_blank" rel="nofollow noopener noreferrer" class="text-indigo-400 underline">
                    @if (now()->lte(Illuminate\Support\Carbon::parse('2022-11-05')->endOfDay()))
                        Get started with <strong class="font-bold">30% off</strong> for 3 months with code <strong class="font-bold italic">TREAT22</strong>.
                    @else
                        Get started with a <strong class="font-bold">3-day free trial</strong> without credit card.
                    @endif
                </a>
            </p>
        </div>
    @elseif ($name === 'kinsta')
        <a href="{{ route('affiliate', 'kinsta') }}" target="_blank" rel="nofollow noopener noreferrer">
            <x-icon-kinsta class="flex-shrink-0 h-4 mt-2" />
        </a>

        <div class="mt-3">
            <p>
                <strong class="font-bold">Focus on writing</strong> SEO optimized content to <strong class="font-bold">promote your business or your name</strong> with a reliable managed WordPress hosting.
            </p>

            <p class="mt-2">
                <a href="{{ route('affiliate', 'kinsta') }}" target="_blank" rel="nofollow noopener noreferrer" class="text-indigo-400 underline">
                    Get 2 months free with Kinsta.
                </a>
            </p>
        </div>
    @endif
</aside>
