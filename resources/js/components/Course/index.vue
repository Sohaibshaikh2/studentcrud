<template>
    <div class="container  mt-5">
        <div class="d-flex mb-5 justify-content-between align-items-center">
            <h2>Courses List</h2>
            <RouterLink class="btn btn-primary" to="/courses/insert">Add New</RouterLink>
        </div>
        <hr>
        <div class="form-group">
            <input
                type="text"
                v-model="searchTerm"
                @input="searchCourse"
                class="form-control"
                placeholder="Search by Course ID or Name"
            />
        </div>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="course in filteredCourses" :key="course.id">
                    <td class="text-center">{{ course.id }}</td>
                    <td class="text-center">{{ course.name }}</td>
                    <td class="text-center">
                        <button
                            class="btn btn-primary"
                            @click="editCourse(course.id)"
                        >
                            Edit
                        </button>
                        <button
                            class="btn btn-danger"
                            style="margin-left: 10px"
                            @click="deleteCourse(course.id)"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from "axios";
import { RouterLink } from "vue-router";

export default {
    data() {
        return {
            courses: [],
            searchTerm: "",
            filteredCourses: [],
        };
    },
    methods: {
        async fetchCourses() {
            try {
                const response = await axios.get(
                    "http://127.0.0.1:8000/api/ShowCourse"
                );
                this.courses = response.data;
                this.filteredCourses = this.courses;
            } catch (error) {
                console.error("Error fetching courses:", error);
            }
        },

        searchCourse() {
            if (this.searchTerm.trim() === "") {
                this.filteredCourses = this.courses;
            } else {
                this.filteredCourses = this.courses.filter(
                    (course) =>
                        course.name
                            .toLowerCase()
                            .includes(this.searchTerm.toLowerCase()) ||
                        course.id.toString().includes(this.searchTerm)
                );
            }
        },

        editCourse(courseId) {
            this.$router.push(`/course/edit/${courseId}`);
        },

        deleteCourse(courseId) {
            if (confirm("Are you sure you want to delete this course?")) {
                axios
                    .delete(`http://127.0.0.1:8000/api/DeleteCourse/${courseId}`)
                    .then((response) => {
                        alert(response.data.message);
                        this.fetchCourses();
                    })
                    .catch((error) => {
                        console.error("Error deleting course:", error);
                        alert("An error occurred while deleting the course.");
                    });
            }
        },
    },
    mounted() {
        this.fetchCourses();
    },
};
</script>

<style>
.table {
    margin-top: 20px;
}

.form-group {
    margin-bottom: 15px;
}

input[type="text"] {
    width: 100%;
}
</style>
