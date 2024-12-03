
<!-- resources/js/components/ExampleComponent.vue -->
<template>
  <div>
    <p>Count: {{ counter.count }}</p>
    <button @click="counter.increment">Increment</button>
  </div>
</template>

<script>
import { useCounterStore } from '../stores/counter';

export default {
  setup() {
    const counter = useCounterStore();
    return { counter };
  },
};
</script>
