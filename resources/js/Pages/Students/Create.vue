<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  name: null,
  age: '',
  status: 'active',
  image: null,
})

function onFileChange(event) {
  console.log('File selected:', event.target.files[0]);
  form.image = event.target.files[0];
}
function submit() {
  console.log('Creating student:', form);
  form.post('/students')
}
</script>

<template>
  <form @submit.prevent="submit">
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" v-model="form.name" required>
      </div>
      <div>
        <label for="age">Age:</label>
        <input type="number" id="age" v-model="form.age" required>
      </div>
      <div>
        <label for="status">Status:</label>
        <select id="status" v-model="form.status" required>
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
        </select>
      </div>
      <div>
        <label for="image">Image:</label>
        <input type="file" name="image" @change="onFileChange($event)" />
        <progress v-if="form.progress" :value="form.progress.percentage" max="100">
          {{ form.progress.percentage }}%
        </progress>
      </div>
      <div>
        <button type="submit">Create Student</button>
      </div>
  </form>
</template>
