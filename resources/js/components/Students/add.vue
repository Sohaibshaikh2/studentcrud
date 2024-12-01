<template>
    <div class="container-fluid p-5">

        <div class="card">

            <div class="card-header">
                 <h3>Add Student</h3>
            </div>

            <div class="card-body">

                <form @submit.prevent="saveData">

                    <div class="form-group">
                        <label class="mb-3" for="name">Student Name</label>
                        <input
                            id="name"
                            class="form-control"
                            v-model="student.name"
                            type="text"
                            placeholder="Student Name"
                            required
                        />
                    </div>

                    <div class="form-group">
                        <label class="mb-3" for="email">Student Email</label>
                        <input
                            id="email"
                            class="form-control"
                            v-model="student.email"
                            type="email"
                            required
                            placeholder="Email"
                        />
                    </div>

                    <button class="btn btn-primary" type="submit">Save</button>

                </form>

            </div>
        </div>

    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            student: {
                name: '',
                email: '',
            },
        };
    },
    methods: {
        async saveData() {
            try {
                const response = await axios.post('http://127.0.0.1:8000/api/AddStudent', this.student);
                alert('Student added successfully!');
            
                this.student.name = '';
                this.student.email = '';
            } catch (error) {
                console.error('Error saving student:', error);
                alert('Error saving student.');
            }
        },
    },
};
</script>

<style scoped>
.container {
    max-width: 100%;
    margin: auto;
    padding: 20px;
}

.form-group {
    margin-bottom: 15px;
}
</style>
