<template>
    <div class="container-fluid mt-5 p-5">
     <div class="card car-bordered">
    <div class="card-header">
        <h2>Students List</h2>

       
        <div class="form-group">
            <input
                type="text"
                v-model="searchTerm"
                @input="searchStudent"
                class="form-control"
                placeholder="Search by ID, Name or Email"
            />
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Enrolled Courses</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="student in filteredStudents" :key="student.id">
                    <td class="text-center">{{ student.student_id }}</td>
                    <td class="text-center">{{ student.student_name }}</td>
                    <td class="text-center">{{ student.student_email }}</td>
                    <td class="text-center">
                        {{ student.course_names }}
                    </td>
                    <td class="text-center">
                        <button
                            class="btn btn-primary"
                            @click="editStudent(student.student_id)"
                        >
                            Edit
                        </button>
                        <button
                            class="btn btn-danger"
                            style="margin-left: 10px;"
                            @click="deleteStudent(student.student_id)"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    </div>
    
</div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            students: [],

            courses: [],
            searchTerm: "",
            filteredStudents: [],
        };
    },
    methods: {
        async fetchStudents() {
            try {
                const response = await axios.get(
                    "http://127.0.0.1:8000/api/ShowStudent"
                );
                this.students = response.data;
                this.student_id = response.data.id;
                this.filteredStudents = this.students;
            } catch (error) {
                console.error("Error fetching students:", error);
            }
        },

        searchStudent() {
            if (this.searchTerm.trim() === "") {
                this.filteredStudents = this.students;
            } else {
                this.filteredStudents = this.students.filter(
                    (student) =>
                        student.name
                            .toLowerCase()
                            .includes(this.searchTerm.toLowerCase()) ||
                        student.email
                            .toLowerCase()
                            .includes(this.searchTerm.toLowerCase()) ||
                        student.id.toString().includes(this.searchTerm)
                );
            }
        },

        editStudent(studentId) {
            this.$router.push(`/student/edit/${studentId}`);
        },

        deleteStudent(studentId) {
        if (
            confirm(
                "Are you sure you want to delete this student and all associated courses?"
            )
        ) {
            axios
                .delete(`http://127.0.0.1:8000/api/DeleteStudent/${studentId}`)
                .then((response) => {
                    alert(response.data.message);
                    this.fetchStudents(); // Refresh the students list after delete
                })
                .catch((error) => {
                    console.error("Error deleting student and courses:", error);
                    alert("An error occurred while deleting the student.");
                });
        }
    },
    },

  
    mounted() {
        this.fetchStudents();
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
