<template>
  <div class="container mx-auto p-4">
    <table class="table-auto w-full border-collapse border border-gray-300">
      <thead class="bg-gray-100">
        <tr>
          <th class="border border-gray-300 px-4 py-2" v-if="isAdmin">ID</th>
          <th class="border border-gray-300 px-4 py-2" v-if="isAdmin">ID del producto</th>
          <th class="border border-gray-300 px-4 py-2">Producto comprado</th>
          <th class="border border-gray-300 px-4 py-2">Cantidad</th>
          <th class="border border-gray-300 px-4 py-2" v-if="isAdmin">ID del usuario</th>
          <th class="border border-gray-300 px-4 py-2" v-if="isAdmin">Numero de venta</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="sale in sales" :key="sale.id">
          <td class="border border-gray-300 px-4 py-2" v-if="isAdmin">{{ sale.id }}</td>
          <td class="border border-gray-300 px-4 py-2" v-if="isAdmin">{{ sale.Products_Id }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ sale.ProductBought }}</td>
          <td class="border border-gray-300 px-4 py-2">{{ sale.Amount }}</td>
          <td class="border border-gray-300 px-4 py-2" v-if="isAdmin">{{ sale.users_Id }}</td>
          <td class="border border-gray-300 px-4 py-2" v-if="isAdmin">{{ sale.sale_number }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

export default {
  data() {
    return {
      sales: [],
    };
  },
  computed: {

    user() {
      const { props } = usePage();
      return props.auth.user;
    },

    isAdmin() {
        console.log(this.user.name)
      return this.user && this.user.name === 'admin';
    },
  },
  mounted() {
    this.fetchSales();
  },
  methods: {
    async fetchSales() {
      try {
        let url = '/sales/data';


        if (!this.isAdmin) {
          console.log('Fetching sales for user:', this.user.id);
          url = `/sales/data/${this.user.id}`;
        }
          console.log(url)

        const response = await axios.get(url);
        this.sales = response.data;
      } catch (error) {
        console.error('Error fetching sales data:', error);
      }
    },
  },
};
</script>

<style scoped>
.table-auto {
  border-collapse: collapse;
  width: 100%;
}
.border {
  border: 1px solid #ccc;
}
</style>
