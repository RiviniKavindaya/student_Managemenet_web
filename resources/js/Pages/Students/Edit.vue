<template>
  <div>
    <h1>Edit Student</h1>
    <form @submit.prevent="updateStudent">
      <div>
        <label for="name">Name:</label>
        <input type="text" id="name" v-model="formData.name" required>
      </div>
      <div>
        <label for="age">Age:</label>
        <input type="number" id="age" v-model="formData.age" required>
      </div>
      <div>
        <label for="status">Status:</label>
        <select id="status" v-model="formData.status" required>
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
        </select>
      </div>
      <button type="submit">Update</button>
    </form>
  </div>
</template>

<script>
import { usePage } from '@inertiajs/inertia-vue3'
import { reactive } from 'vue'

export default {
  props: {
    student: Object 
  },
  setup(props) {
    const { $inertia } = usePage()
    const formData = reactive({
      name: props.student.name,
      age: props.student.age,
      status: props.student.status
    })

    const updateStudent = async () => {
      try {
        await $inertia.put(route('students.update', { student: props.student.id }), formData)
      } catch (error) {
        console.error(`Error updating student ${props.student.id}:`, error)
      }
    }

    return { formData, updateStudent }
  }
}
</script>
