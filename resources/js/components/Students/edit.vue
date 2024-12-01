<template>
    <div class="container mt-5">
        <h2>Edit Student</h2>

        <!-- Student Details -->
        <div v-if="student">
            <div class="form-group">
                <label for="name">Name:</label>
                <input
                    id="name"
                    v-model="student.name"
                    type="text"
                    class="form-control"
                    required
                />
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input
                    id="email"
                    v-model="student.email"
                    type="email"
                    class="form-control"
                    required
                />
            </div>
        </div>

        <!-- Assigned Courses -->
        <div v-if="courses.length">
            <h3>Assigned Courses</h3>
            <ol>
                <li v-for="(course, index) in courses" :key="course.id">
                    {{ course.name }}
                    <button
                        class="btn text-danger ml-2"
                        style="font-weight: bold"
                        @click="removeCourse(index)"
                    >
                        x
                    </button>
                </li>
            </ol>
        </div>

        <!-- Add New Course -->
        <div v-if="allCourses.length">
            <label for="course">Add Course:</label>
            <select
                id="course"
                v-model="selectedCourse"
                class="form-control"
                @change="addCourse"
            >
                <option value="" disabled>Select a course</option>
                <option
                    v-for="course in allCourses"
                    :key="course.id"
                    :value="course.id"
                >
                    {{ course.name }}
                </option>
            </select>
        </div>

        <!-- Error Message -->
        <div v-if="errorMessage" class="alert alert-danger mt-3">
            {{ errorMessage }}
        </div>

        <!-- Save Button -->
        <button class="btn btn-success mt-3" @click="saveChanges">
            Save Changes
        </button>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            student: null, // Student details
            courses: [], // Assigned courses
            allCourses: [], // All available courses
            selectedCourse: null, // New course to add
            errorMessage: "", // Error message
        };
    },
    methods: {
        // Fetch student details and courses
        async fetchStudentDetails() {
            const studentId = this.$route.params.id;
            try {
                const response = await axios.get(
                    `http://127.0.0.1:8000/api/EditStudent/${studentId}`
                );
                this.student = response.data.student;
                this.courses = response.data.courses;
            } catch (error) {
                this.errorMessage = "Unable to fetch student details.";
            }
        },

        // Fetch all courses
        async fetchAllCourses() {
            try {
                const response = await axios.get(
                    "http://127.0.0.1:8000/api/ShowCourse"
                );
                this.allCourses = response.data;
            } catch (error) {
                this.errorMessage = "Unable to fetch courses.";
            }
        },

        // Add new course
        // Add new course on dropdown change
        addCourse() {
            if (!this.selectedCourse) return;

            // Check if the student already has 5 courses assigned
            if (this.courses.length >= 5) {
                this.errorMessage = "Student cannot have more than 5 courses.";
                return;
            }

            // Check if the course is already assigned
            if (
                !this.courses.find(
                    (course) => course.id === this.selectedCourse
                )
            ) {
                const course = this.allCourses.find(
                    (course) => course.id === this.selectedCourse
                );
                this.courses.push(course); // Add to assigned courses
                this.errorMessage = ""; // Clear any previous error messages
            } else {
                this.errorMessage = "Course is already assigned.";
            }

            this.selectedCourse = null; // Reset dropdown
        },
        // Remove a course
        removeCourse(index) {
            this.courses.splice(index, 1);
        },

        // Save changes
        async saveChanges() {
            try {
                const studentId = this.$route.params.id;
                const response = await axios.put(
                    `http://127.0.0.1:8000/api/UpdateStudent/${studentId}`,
                    {
                        name: this.student.name,
                        email: this.student.email,
                        courses: this.courses.map((course) => course.id),
                    }
                );
                alert(response.data.success);
                this.$router.push("/"); 
            } catch (error) {
                this.errorMessage = "Unable to save changes.";
            }
        },
    },
    mounted() {
        this.fetchStudentDetails();
        this.fetchAllCourses();
    },
};
</script>
