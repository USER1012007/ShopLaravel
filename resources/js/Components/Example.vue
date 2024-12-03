<template>
  <div>
    <ul>
      <li v-for="item in items" :key="item.id">{{ item.name }}</li>
      <li v-for="item in items" :key="item.id">{{ item.email }}</li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';
import NavLink from '../Components/NavLink.vue';

export default {
  data() {
    return {
      items: []
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      axios.get('/api/data') // URL should match the Laravel route
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
