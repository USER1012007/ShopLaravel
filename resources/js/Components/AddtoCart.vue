<template>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
    <div
      v-for="item in items.sort((a, b) => a.Id - b.Id)"
      :key="item.Id"
      class="max-w-sm rounded overflow-hidden shadow-lg bg-white dark:bg-gray-800"
    >
      <img class="w-full" :src="imageUrl" :alt="item.Name" />

      <div class="px-6 py-4">
        <div class="font-bold text-xl mb-2">{{ item.Name }}</div>
        <p class="text-gray-700 text-base dark:text-gray-300">
          Precio: ${{ item.Price }} <br />
          Unidades: {{ item.AmountAvailable }}
        </p>
      </div>
      <div class="px-6 pt-4 pb-2">
        <button
          class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2 dark:bg-gray-700 dark:text-gray-300"
          @click="AddItem(item)">
          Agregar
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { useCartStore } from '../stores/cartStore.js';
import axios from 'axios';

export default {
  computed: {
    cart() {
      const cartStore = useCartStore();
      return cartStore.cart;
    },
    items() {
      return this.items;
    }
  },
  data() {
    return {
      items: [],
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    AddItem(item) {
      const cartStore = useCartStore();
      cartStore.addItem(item);
    },

    removeItem(item) {
      const cartStore = useCartStore();
      cartStore.removeItem(item);
    },

    fetchData() {
      axios.get('/admin/data')
        .then(response => {
          this.items = response.data;
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
    }
  }
};
</script>
