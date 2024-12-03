<template>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
    <div
      v-for="item in items.sort((a, b) => a.Id - b.Id)"
      :key="item.Id"
      class="max-w-sm rounded overflow-hidden shadow-lg bg-white dark:bg-gray-800"
    >

      <div class="px-6 py-4">
        <div class="font-bold text-xl mb-2">
          <template v-if="editingId !== item.Id">{{ item.Name }}</template>
          <template v-else>
            <input
              v-model="editedItem.Name"
              class="border rounded px-2 py-1 w-full"
              placeholder="Edit Name"
            />
          </template>
        </div>

        <p class="text-gray-700 text-base dark:text-gray-300" v-if="editingId !== item.Id">
          Precio: ${{ item.Price }} <br />
          Disponibles: {{ item.AmountAvailable }}
        </p>

        <div v-else>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Precio:
          </label>
          <input
            v-model="editedItem.Price"
            type="number"
            class="border rounded px-2 py-1 w-full"
          />
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-2">
            Disponibles:
          </label>
          <input
            v-model="editedItem.AmountAvailable"
            type="number"
            class="border rounded px-2 py-1 w-full"
          />
        </div>
      </div>

      <div class="px-6 pt-4 pb-2">
        <button
          class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2 dark:bg-gray-700 dark:text-gray-300"
          @click="destroy(item.Id)"
        >
          Eliminar
        </button>

        <template v-if="editingId !== item.Id">
          <button
            class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2 dark:bg-gray-700 dark:text-gray-300"
            @click="startEdit(item)"
          >
            Editar
          </button>
        </template>
        <template v-else>
          <button
            class="inline-block bg-green-500 text-white rounded-full px-3 py-1 text-sm font-semibold mr-2 mb-2"
            @click="update(item.Id)"
          >
            Guardar
          </button>
          <button
            class="inline-block bg-red-500 text-white rounded-full px-3 py-1 text-sm font-semibold mr-2 mb-2"
            @click="cancelEdit"
          >
            Cancelar
          </button>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      items: [],
      editingId: null,
      editedItem: {},
      imageUrl: 'https://via.placeholder.com/150'
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      axios
        .get('/admin/data')
        .then(response => {
          this.items = response.data;
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
    },
    destroy(itemId) {
      axios
        .delete(`/admin/data/${itemId}`)
        .then(response => {
          console.log(response.data.message);
          this.items = this.items.filter(item => item.Id !== itemId);
        })
        .catch(error => {
          console.error('Error deleting item:', error);
        });
    },
    startEdit(item) {
      this.editingId = item.Id;
      this.editedItem = { ...item };
    },
    cancelEdit() {
      this.editingId = null;
      this.editedItem = {};
    },
    update(id) {
      console.log('Sending data:', this.editedItem);
      console.log(id);
      axios
      .put(`/admin/update/${id}`, this.editedItem, {
        headers: { 'Content-Type': 'application/json' },
      })
      .then(response => {
        console.log(response.data.message);
        this.cancelEdit();
      })
      .catch(error => {
        console.error('Error updating item:', error.response?.data || error.message);
      });
    }
  }
};
</script>
