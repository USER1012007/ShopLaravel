import { defineStore } from 'pinia';
import axios from 'axios';

export const useCartStore = defineStore('cart', {
  state: () => ({
    cart: [],
    items: [],
  }),

  actions: {

    async fetchItems() {
      try {
        const response = await axios.get('/admin/data');
        this.items = response.data;
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    },


    addItem(item) {
      const existingItem = this.cart.find(cartItem => cartItem.Id === item.Id);

      if (existingItem) {
        if (item.AmountAvailable > 0) {
          existingItem.Quantity += 1;
          item.AmountAvailable -= 1;
        } else {
          alert('No more items available!');
        }
      } else {
        if (item.AmountAvailable > 0) {
          this.cart.push({ ...item, Quantity: 1 });
          item.AmountAvailable -= 1;
        } else {
          alert('No more items available!');
        }
      }
    },


    removeItem(item) {
      const existingItem = this.cart.find(cartItem => cartItem.Id === item.Id);

      if (existingItem) {
        if (existingItem.Quantity > 1) {
          existingItem.Quantity -= 1;
          const itemToUpdate = this.getItemById(item.Id);
          if (itemToUpdate) itemToUpdate.AmountAvailable += 1;
        } else {
          this.cart = this.cart.filter(cartItem => cartItem.Id !== item.Id);
          const itemToUpdate = this.getItemById(item.Id);
          if (itemToUpdate) itemToUpdate.AmountAvailable += 1;
        }
      }
    },


    clearCart() {
      this.cart.forEach(cartItem => {
        const item = this.getItemById(cartItem.Id);
        if (item) item.AmountAvailable += cartItem.Quantity;
      });
      this.cart = [];
    },


    getItemById(id) {
      return this.items.find(item => item.Id === id);
    },


    async completeSale() {
      try {
        const cartData = this.cart;
        const response = await axios.post('/api/sales', {
          cart: cartData,
        });
        console.log('Sale completed:', response.data);
        this.cart = [];
        alert('Sale completed successfully!');
      } catch (error) {
        console.error('Error completing sale:', error);
        alert('There was an error completing the sale. Please try again.');
      }
    },
  },
});
