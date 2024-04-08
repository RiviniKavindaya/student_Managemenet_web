<script >
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head ,Link} from '@inertiajs/vue3';

export default {
  props: {
    students: Array
  },
  methods: {
    async deleteStudent(id) {
      try {
        const response = await fetch(`http://127.0.0.1:8000/students/${id}`, {
          method: 'DELETE',
        });
        
        if (!response.ok) {
          throw new Error('Failed to delete student');
        }
        
        
        this.students = this.students.filter(student => student.id !== id);
      } catch (error) {
        console.error('Error deleting student:', error);
      }
    },
    addStudent() {
      window.location.href = '/students/create';
    },
    editStudent(id) {
      window.location.href = `/students/${id}/edit`;
    }
  }
}
</script>

<template>
    <Head title="Students" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Students</h2>
        </template>
        <div>
            <button @click="addStudent">Add student</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="student in students" :key="student.id">
                    <td>{{ student.name }}</td>
                    <td>{{ student.age }}</td>
                    <td>{{ student.status }}</td>
                    <td><img :src="student.image"></td>
                    <td>
                      
                        <button @click="editStudent(student.id)">Edit</button>
                    </td>
                    <td>
                        <button @click="deleteStudent(student.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }

  th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }

  th {
    background-color: #f2f2f2;
  }
</style>
