<script setup lang="ts">
import { ref, reactive } from 'vue';
import { IShoppingCart, IOrderSummary } from '../interfaces/shopping_cart';
import Suggestions from './Suggestions.vue';
import ApiService from '../services/api';


interface IProduct {
  id: number;
  name: string;
  image: string;
  active: number;
  brand: string;
  category: string;
  color: string;
  created_at: string;
  description: string;
  price: string;
  stock: number;
  updated_at: string;
  weight: number;
}

interface IShoppingCartItem {
  id: number;
  product_id: number;
  quantity: number;
  customer_id: number | null;
  product: IProduct;
  created_at: string;
  updated_at: string;
}

interface ICartSummary {
  cartItems: IShoppingCartItem[];
  total: number; // Sepetin toplam fiyatı
  tax: number; // Vergi
  grandTotal: number; // Vergi dahil toplam
  originalPrice: number; // İndirim öncesi toplam fiyat
  savings: number; // Toplam tasarruf
}

const cartItems = ref<IShoppingCartItem[]>([]);

const cartSummary = ref<ICartSummary>();


const getCartItems = async (): Promise<void> => {
  try {
    const response = await ApiService.getCartItems();
    console.log(response.data);
    cartItems.value = response.data.cartItems;
    cartSummary.value = response.data.cartSummary;
  } catch (error) {
    console.log(error);
    throw error;
  }
}

getCartItems();


const shoppingCart = reactive<IShoppingCart>({
  items: [],
  total: 0,
  quantity: 1,
});

const orderSummary = reactive<IOrderSummary>({ // state de tutulacak ve tax orani dinamik ayarlanacak ya da const sabit ile
  originalPrice: 0,
  savings: 0,
  storePickups: 0,
  tax: 0,
  total: 0,
});

const deleteItem = async (id: number): Promise<void> => {
  try {
    const response = await ApiService.deleteCartItem(id);
    console.log(response.data);
    getCartItems();
  } catch (error) {
    console.log(error);
    throw error;
  }
}
const updateQuantity = async (type: string, id: number): Promise<void> => {
  try {
    const response = await ApiService.updateCartItem(type, id);
    console.log(response.data);
    getCartItems();
  } catch (error) {
    console.log(error);
    throw error;
  }
}

</script>

<template>
  <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16">
    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
      <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Alışveriş Sepeti</h2>
      <div class="mt-6 sm:mt-8 md:gap-6 lg:flex lg:items-start xl:gap-8">
        <div class="mx-auto w-full flex-none lg:max-w-2xl xl:max-w-4xl">
          <div class="space-y-6">
            <div v-if="shoppingCart.items.length == 0" v-for="item in cartItems" :key="item.id"
              class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 md:p-6">
              <div class="space-y-4 md:flex md:items-center md:justify-between md:gap-6 md:space-y-0">
                <a href="#" class="shrink-0 md:order-1">
                  <img class="h-20 w-20 dark:hidden" :src="`http://127.0.0.1:8000/storage/` + item.product.image"
                    :alt="item.product.name" />
                  <img class="hidden h-20 w-20 dark:block"
                    src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front-dark.svg" alt="imac image" />
                </a>

                <label for="counter-input" class="sr-only">Choose quantity:</label>
                <div class="flex items-center justify-between md:order-3 md:justify-end">
                  <div class="flex items-center">
                    <button @click="updateQuantity('decrement', item.id)" type="button" id="decrement-button"
                      class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                      <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M1 1h16" />
                      </svg>
                    </button>
                    <input type="text" :value="item.quantity" id="counter-input" data-input-counter
                      class="w-10 shrink-0 border-0 bg-transparent text-center text-sm font-medium text-gray-900 focus:outline-none focus:ring-0 dark:text-white"
                      placeholder="" required />
                    <button @click="updateQuantity('increment', item.id)" type="button" id="increment-button"
                      class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                      <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 1v16M1 9h16" />
                      </svg>
                    </button>
                  </div>
                  <div class="text-end md:order-4 md:w-32">
                    <p class="text-base font-bold text-gray-900 dark:text-white">${{ item.product.price }}</p>
                  </div>
                </div>

                <div class="w-full min-w-0 flex-1 space-y-4 md:order-2 md:max-w-md">
                  <a :href="`/urun/${item.product_id}`"
                    class="text-base font-medium text-gray-900 hover:underline dark:text-white">
                    {{ item.product.name }}</a>

                  <div class="flex items-center gap-4">
                    <button type="button"
                      class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 hover:underline dark:text-gray-400 dark:hover:text-white">
                      <svg class="me-1.5 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                      </svg>
                      Favorilere ekle
                    </button>

                    <button @click="deleteItem(item.id)" type="button"
                      class="inline-flex items-center text-sm font-medium text-red-600 hover:underline dark:text-red-500">
                      <svg class="me-1.5 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18 17.94 6M18 18 6.06 6" />
                      </svg>
                      Kaldır
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <span v-else class="block text-center text-2xl h-px h-py w-full bg-gray-200 dark:bg-gray-700">
              Sepetinizde ürün bulunmuyor.
            </span>
          </div>
          <Suggestions />
        </div>

        <div class="mx-auto mt-6 max-w-4xl flex-1 space-y-6 lg:mt-0 lg:w-full">
          <div
            class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
            <p class="text-xl font-semibold text-gray-900 dark:text-white">Sipariş özeti</p>

            <div class="space-y-4">
              <div class="space-y-2">
                <dl class="flex items-center justify-between gap-4">
                  <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Orijinal fiyat</dt>
                  <dd class="text-base font-medium text-gray-900 dark:text-white">${{ cartSummary?.originalPrice }}</dd>
                </dl>

                <dl class="flex items-center justify-between gap-4">
                  <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Tasarruf</dt>
                  <dd class="text-base font-medium text-gray-900"
                    :class="{ 'text-green-600': cartSummary?.savings > 0, 'text-red-600': cartSummary?.savings < 0 }">
                    ${{ cartSummary?.savings.toFixed(2) }}
                  </dd>
                </dl>

                <dl class="flex items-center justify-between gap-4">
                  <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Mağazadan Teslim Alma</dt>
                  <dd class="text-base font-medium text-gray-900 dark:text-white">${{ cartSummary?.savings.toFixed(2) }}
                  </dd>
                </dl>

                <dl class="flex items-center justify-between gap-4">
                  <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Vergi</dt>
                  <dd class="text-base font-medium text-gray-900 dark:text-white">${{ cartSummary?.tax.toFixed(2) }}
                  </dd>
                </dl>
              </div>

              <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                <dt class="text-base font-bold text-gray-900 dark:text-white">Toplam</dt>
                <dd class="text-base font-bold text-gray-900 dark:text-white">${{ cartSummary?.total.toFixed(2) }}</dd>
              </dl>
            </div>

            <a href="/odeme"
              class="flex w-full items-center justify-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Ödeme
              İşlemine Geç</a>

            <div class="flex items-center justify-center gap-2">
              <span class="text-sm font-normal text-gray-500 dark:text-gray-400"> ya da </span>
              <a href="/magaza" title=""
                class="inline-flex items-center gap-2 text-sm font-medium text-blue-700 underline hover:no-underline dark:text-blue-500">
                Alışverişe devam et
                <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 12H5m14 0-4 4m4-4-4-4" />
                </svg>
              </a>
            </div>
          </div>

          <div
            class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
            <form class="space-y-4">
              <div>
                <label for="voucher" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Kuponunuz
                  veya hediye kartınız var mı? </label>
                <input type="text" id="voucher"
                  class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                  placeholder="" required />
              </div>
              <button type="submit"
                class="flex w-full items-center justify-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Kodu
                Uygula</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped></style>