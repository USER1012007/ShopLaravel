<template>
  <form @submit.prevent="submitForm" enctype="multipart/form-data">
    <div>
      <label for="name">Nombre:</label>
      <input v-model="formData.Name" type="text" id="name" name="name" required>
    </div>
    <div>
      <label for="price">Precio:</label>
      <input v-model="formData.Price" type="number" id="price" name="price" required step="0.0000001">
    </div>
    <div>
      <label for="amountavailable">Cantidad:</label>
      <input v-model="formData.AmountAvailable" type="number" id="amountavailable" name="amountavailable" required>
    </div>
    <button type="submit">Submit</button>
  </form>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      formData: {
        Name: '',
        Price: '',
        AmountAvailable: '',
        picture: null,
      },
      selectedFile: null,
    };
  },
  methods: {
    handleFileUpload(event) {
      this.selectedFile = event.target.files[0];
    },
    submitForm() {
      const formData = new FormData();


      formData.append('Name', this.formData.Name);
      formData.append('Price', this.formData.Price);
      formData.append('AmountAvailable', this.formData.AmountAvailable);


      if (this.selectedFile) {
        formData.append('picture', this.selectedFile);
      }


      axios.post('/admin/create', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      })
        .then(response => {
          console.log('Item added successfully:', response.data);
          window.location.reload();
        })
        .catch(error => {
          console.error('Error submitting form:', error.response.data);
        });
    },
  },
};
</script>
