<x-app
    title="Best SaaS products in the AI, SEO, web hosting area & more"
    description=""
    class="dark:bg-gray-900 text-gray-600 dark:text-gray-300"
>
    <x-blog.top class="container mt-4 md:mt-8" />

    <x-breadcrumb class="container mt-8 sm:mt-16">
        <x-breadcrumb-item href="{{ route('posts.index') }}">
            Blog
        </x-breadcrumb-item>

        <x-breadcrumb-item>
            Deals
        </x-breadcrumb-item>
    </x-breadcrumb>

    <section class="container max-w-[1024px] mt-16">
        <h1 class="font-thin text-3xl md:text-5xl dark:text-white">
            Best SaaS products in the AI, SEO, web hosting area & more
        </h1>

        @forelse ($categories as $category)
            <h2 class="font-bold mt-8 sm:mt-16 px-4 sm:px-0 text-xl">
                Best {{ $category->name }} SaaS products
            </h2>

            <div class="grid sm:grid-cols-2 gap-4 mt-4">
                @foreach ($category->deals()->orderByDesc('end_at')->get() as $deal)
                    <x-deal :deal="$deal" />
                @endforeach
            </div>
        @empty
            <p class="mt-8 sm:mt-16 text-center text-gray-400">There's no deal yet.</p>
        @endforelse
    </section>

    <div class="bg-gray-900 dark:bg-black flex-grow mt-16">
        <x-footer class="text-gray-200" />
    </div>

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "NewsArticle",
            "headline": "Best SaaS products in the AI, SEO, web hosting area & more",
            "datePublished": "2022-11-15 14:00:00",
            "dateModified": "2022-11-15 14:00:00",
            "author": [
                {
                    "@type": "Person",
                    "name": "Benjamin Crozat",
                    "url": "https://benjamincrozat.com"
                }
            ]
        }
    </script>
</x-app>