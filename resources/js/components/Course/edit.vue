<template>
    <div class="container mt-5 p-5">

        <div class="card">

            <div class="card-header">
                 <h3>Edit Course</h3>
            </div>

            <div class="card-body">

                <form @submit.prevent="saveChanges">

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

        async fetchCourseDetails() {
            const CourseId = this.$route.params.id;
            try {
                const response = await axios.get(
                    `http://127.0.0.1:8000/api/EditCourse/${CourseId}`
                );
                this.course = response.data;
            } catch (error) {
                this.errorMessage = "Unable to fetch Course details.";
            }
        },
        async saveChanges() {
            try {
                const courseId = this.$route.params.id;
                const response = await axios.put(`http://127.0.0.1:8000/api/UpdateCourse/${courseId}`,this.course);
                alert(response.data.message);
                this.$router.push("/courses/index"); 
            } catch (error) {
                this.errorMessage = "Unable to save changes.";
            }
        },
    },
    mounted() {
        
        this.fetchCourseDetails();
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
