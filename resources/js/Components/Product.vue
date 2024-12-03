
<template>
  <div class="Product">
    <h2>{{ title }}</h2>
    <p>{{ content }}</p>
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: 'Product',
  props: {
    title: {
      type: String,
      required: true,
    },
    content: {
      type: String,
      required: true,
    },
  },
};
</script>

<style scoped>
.Product {
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 16px;
  margin: 16px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
h2 {
  margin-bottom: 8px;
}
p {
  color: #555;
}
</style>
