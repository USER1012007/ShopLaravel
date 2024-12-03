<template>
  <button
    @click="addItem(cartItem)">+
  </button>
</template>

<script>
import { useCartStore } from '../stores/cartStore.js';

export default {
  computed: {
    cart() {
      const cartStore = useCartStore();
      return cartStore.cart;
    },
  },
  data() {
    return {
      items: [],
      editedItem: {
        Name: '',
        Price: 0,
        AmountAvailable: 0,
      },
      editingId: null,
    };
  },
  methods: {
    addItem(cartItem) {
        if(cartItem.AmountAvailable > 0) {
          const cartStore = useCartStore();
          cartStore.addItem(cartItem);
        }
    },
  }
};
</script>

<style scoped>
.bg-gray-100 {
  background-color: #f7fafc;
}
.bg-red-500 {
  background-color: #f56565;
}
.bg-green-500 {
  background-color: #48bb78;
}
</style>
