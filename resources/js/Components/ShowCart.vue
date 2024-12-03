<template>
  <div class="grid grid-cols-1 gap-4 ">

    <div class="mt-8 p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-100 p-4 mb-4 rounded-lg shadow-md">
      <div v-if="cart.length > 0">
        <div v-for="(cartItem, index) in cart" :key="index" class="">
          <div class="flex justify-between items-center">
            <div>
              <h3 class="font-bold text-lg">{{ cartItem.Name }}</h3>
              <p class="text-gray-600">Precio: ${{ cartItem.Price }}</p>
              <p class="text-gray-600">Cantidad: {{ cartItem.Quantity }}</p>
            </div>

            <div class="">
              <button
                @click="removeItem(cartItem, items)"
                class="bg-red-500 text-white px-4 py-4 rounded mr-2">-</button>
              <button
                @click="addItem(cartItem)"
                class="bg-green-500 text-white px-4 py-4 rounded">+</button>
            </div>
          </div>
        </div>
      </div>
      <div v-else>
        <p>Tu carrito esta vacio!</p>
      </div>
    </div>
  </div>

  <div :key="index">
    <p class="text-gray-600">Subtotal: ${{ cartSubtotal }}</p>
    <p class="text-gray-600">Iva: ${{ cartIva }}</p>
    <p class="text-gray-600">Total: ${{ cartTotal }}</p>
  </div>
  <div v-if="cart.length > 0" class="mt-4">
    <button
      @click="completeSale()"
      class="w-full py-2 bg-blue-500 text-white font-bold rounded-lg hover:bg-blue-600"
    >
      Proceder al pago
    </button>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';


const { props } = usePage();
const user = computed(() => props.auth.user);
</script>

<script>
import { useCartStore } from '../stores/cartStore.js';
import { usePage } from '@inertiajs/vue3';

export default {
  computed: {
    cart() {
      const cartStore = useCartStore();
      return cartStore.cart;
    },
    items() {
      return this.items;
    },
    cartSubtotal() {
      return this.cart.reduce((subtotal, cartItem) => {
        return subtotal + (cartItem.Price * cartItem.Quantity);
      }, 0);
    },
    cartIva() {
      return this.cartSubtotal * 0.16;
    },
    cartTotal() {
      return this.cartSubtotal + this.cartIva;
    }
  },

  mounted() {
    this.fetchData();
  },
  data() {
    return {
      items: [],
      sale: {
        Products_Id: '',
        Total: '',
        Amount: '',
        WhenBought: '',
      },
    };
  },
  methods: {
    removeItem(cartItem, items) {
      const cartStore = useCartStore();
      items.AmountAvailable += 1;
      cartStore.removeItem(cartItem);
    },
    addItem(cartItem) {
      if (cartItem.AmountAvailable > 0) {
        const cartStore = useCartStore();
        cartStore.addItem(cartItem);
      }
    },
    async completeSale() {

      const { props } = usePage();
      const user = props.auth.user;

      console.log(user);

      try {
        const salesData = this.cart.map(cartItem => ({
          Products_Id: cartItem.Id,
          ProductBought: cartItem.Name,
          Amount: cartItem.Quantity,
          users_Id: user?.id,
        }));
        await axios.post('/sales', { sales: salesData });
        const cartStore = useCartStore();
        cartStore.clearCart();
        alert('Sale completed successfully!');
      } catch (error) {
        console.error('Error completing sale:', error.response?.data || error);
        alert('Failed to complete the sale. Please try again.');
      }
    },
    fetchData() {
      axios.get('/admin/data')
        .then(response => {
          this.items = response.data;
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
    },
  }
};
</script>
