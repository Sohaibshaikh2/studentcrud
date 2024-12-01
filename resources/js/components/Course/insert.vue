<template>
    <div class="container mt-5 p-5">

        <div class="card">

            <div class="card-header">
                 <h3>Add Course</h3>
            </div>

            <div class="card-body">

                <form @submit.prevent="saveData">

                    <div class="form-group">
                        <label class="mb-3" for="name">Course Name</label>
                        <input
                            id="name"
                            class="form-control"
                            v-model="course.name"
                            type="text"
                            placeholder="Course Name"
                            required
                        />
                    </div>

                    <div class="form-group">
                        <label class="mb-3" for="">Discription</label>
                      <textarea class="form-control" name=""  v-model="course.description"  id="">

                      </textarea>
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
            course: {
                name: '',
                description: '',
            },
        };
    },
    methods: {
        async saveData() {
            try {
                const response = await axios.post('http://127.0.0.1:8000/api/AddCourse', this.course);
                alert('Course added successfully!');
                
                this.course.name = '';
                this.course.description = '';
          
            } catch (error) {
                console.error('Error saving Course:', error);
                alert('Error saving Course.');
            }
        },
    },
};
</script>

<style scoped>
.container {
 
    margin: auto;
    padding: 20px;
}

.form-group {
    margin-bottom: 15px;
}
</style>
