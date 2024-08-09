<section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-16">
  <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
      <div class="mb-4 flex items-center justify-between gap-4 md:mb-8">
          <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Kategoriye göre alışveriş yapın</h2>
      </div>

      <form action="{{ route('customers-store') }}" method="GET">
          <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
              @foreach ($categories as $cat)
              <div class="flex items-center rounded-lg border border-gray-200 bg-white px-4 py-2 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                  <input id="category-{{ $cat->category }}" type="checkbox" name="kategori[]" value="{{ $cat->category }}"
                      class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600"
                      {{ in_array($cat->category, request()->kategori ?? []) ? 'checked' : '' }} />
                  <label for="category-{{ $cat->category }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                      {{ $cat->category }} ({{ $cat->count }})
                  </label>
              </div>
              @endforeach
          </div>
          <div class="mt-4">
              <button type="submit" class="rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-800">
                  Filtrele
              </button>
          </div>
      </form>
  </div>
</section>
