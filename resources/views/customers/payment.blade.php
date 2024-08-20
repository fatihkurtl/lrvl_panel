@extends('layouts.customers.customers')

@section('content')
    <section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-16">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <div class="mx-auto max-w-5xl">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Ödeme</h2>
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
                            role="alert">
                            <span class="font-medium">Hata!</span> {{ $error }}
                        </div>
                    @endforeach
                @elseif(isset($message))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                        role="alert">
                        <span class="font-medium">Tebrikler!</span> {{ $message }}
                    </div>
                @endif
                <div class="mt-6 sm:mt-8 lg:flex lg:items-start lg:gap-12">
                    <form action="{{ route('customers-payment-create') }}" method="POST"
                        class="w-full rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6 lg:max-w-xl lg:p-8">
                        @csrf
                        <div class="mb-6 grid grid-cols-2 gap-4">
                            <div class="col-span-2 sm:col-span-1">
                                <label for="full_name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                    Tam ad (kart üzerindeki gibi)* </label>
                                <input type="text" id="full_name" name="full_name"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                    placeholder="Bonnie Green" />
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="card-number-input"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Kart numarası*
                                </label>
                                <input type="text" id="card-number-input" name="cart_number"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 pe-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500  dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                    placeholder="xxxx-xxxx-xxxx-xxxx" />
                            </div>

                            <div>
                                <label for="card-expiration-input"
                                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Kartın son kullanma
                                    tarihi* </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
                                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M5 5a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1h1a1 1 0 0 0 1-1 1 1 0 1 1 2 0 1 1 0 0 0 1 1 2 2 0 0 1 2 2v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7a2 2 0 0 1 2-2ZM3 19v-7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Zm6.01-6a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm-10 4a1 1 0 1 1 2 0 1 1 0 0 1-2 0Zm6 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0Zm2 0a1 1 0 1 1 2 0 1 1 0 0 1-2 0Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input datepicker datepicker-format="mm/yy" id="card-expiration-input"
                                        name="expiration_date" type="text"
                                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-9 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                        placeholder="12/23" required />
                                </div>
                            </div>
                            <div>
                                <label for="cvv-input"
                                    class="mb-2 flex items-center gap-1 text-sm font-medium text-gray-900 dark:text-white">
                                    CVV*
                                    <button data-tooltip-target="cvv-desc" data-tooltip-trigger="hover"
                                        class="text-gray-400 hover:text-gray-900 dark:text-gray-500 dark:hover:text-white">
                                        <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.408-5.5a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4a1 1 0 0 0-1-1h-2Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div id="cvv-desc" role="tooltip"
                                        class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700">
                                        Kartın arkasındaki son 3 rakam
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </label>
                                <input type="number" id="cvv-input" name="cvv"
                                    aria-describedby="helper-text-explanation"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                    placeholder="•••" required />
                            </div>
                            <input type="hidden" name="price" value="{{ isset($total) ? $total : 0 }}" />
                        </div>
                        <button type="submit"
                            class="flex w-full items-center justify-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4  focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Şimdi
                            öde</button>
                    </form>

                    <div class="mt-6 grow sm:mt-8 lg:mt-0">
                        <div
                            class="space-y-4 rounded-lg border border-gray-100 bg-gray-50 p-6 dark:border-gray-700 dark:bg-gray-800">
                            <div class="space-y-2">
                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Orijinal fiyat</dt>
                                    <dd class="text-base font-medium text-gray-900 dark:text-white">${{ isset($originalPrice) ? $originalPrice : 0 }}
                                    </dd>
                                </dl>

                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Tasarruf</dt>
                                    <dd class="text-base font-medium text-green-500">-${{ isset($savings) ? $savings : 0 }}</dd>
                                </dl>

                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Mağazadan Teslim Alma
                                    </dt>
                                    <dd class="text-base font-medium text-gray-900 dark:text-white">${{ isset($savings) ? $savings : 0 }}
                                    </dd>
                                </dl>

                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Vergi</dt>
                                    <dd class="text-base font-medium text-gray-900 dark:text-white">${{ isset($tax) ? $tax : 0 }}
                                    </dd>
                                </dl>
                            </div>

                            <dl
                                class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                                <dt class="text-base font-bold text-gray-900 dark:text-white">Toplam</dt>
                                <dd class="text-base font-bold text-gray-900 dark:text-white">${{ isset($total) ? $total : 0 }}</dd>
                            </dl>
                        </div>

                        <div class="mt-6 flex items-center justify-center gap-8">
                            <img class="h-8 w-auto dark:hidden"
                                src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/paypal.svg"
                                alt="" />
                            <img class="hidden h-8 w-auto dark:flex"
                                src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/paypal-dark.svg"
                                alt="" />
                            <img class="h-8 w-auto dark:hidden"
                                src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/visa.svg"
                                alt="" />
                            <img class="hidden h-8 w-auto dark:flex"
                                src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/visa-dark.svg"
                                alt="" />
                            <img class="h-8 w-auto dark:hidden"
                                src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/mastercard.svg"
                                alt="" />
                            <img class="hidden h-8 w-auto dark:flex"
                                src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/brand-logos/mastercard-dark.svg"
                                alt="" />
                        </div>
                    </div>
                </div>

                <p class="mt-6 text-center text-gray-500 dark:text-gray-400 sm:mt-8 lg:text-left">
                    Payment processed by <a href="#" title=""
                        class="font-medium text-blue-700 underline hover:no-underline dark:text-blue-500">Paddle</a> for <a
                        href="#" title=""
                        class="font-medium text-blue-700 underline hover:no-underline dark:text-blue-500">Flowbite LLC</a>
                    - United States Of America
                </p>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
@endpush
