<template>
    <div class="container mt-5">
      <h2>Enroll New Student</h2>
  
  
      <div class="form-group">
        <label for="student">Select Student:</label>
        <select
          id="student"
          v-model="selectedStudent"
          class="form-select"
          required
         
        >
          <option selected value="" disabled>Select a student</option>
          <option v-for="student in students" :key="student.student_id" :value="student.student_id">
            {{ student.student_name }}
          </option>
        </select>
      </div>
      
 
      <div class="form-group">
        <label for="courses">Available Courses:</label>
        <select
          id="courses"
          v-model="selectedCourse"
          class="form-select"
          @change="addCourseToCart" 
        >
          <option value="" selected disabled>Select a course</option>
          <option v-for="course in courses" :key="course.id" :value="course">
            {{ course.name }}
          </option>
        </select>
      </div>
  
  
      <div v-if="cart.length" class="form-group">
        <h3>Selected Courses:</h3>
        <ol>
          <li v-for="(course, index) in cart" :key="index">
            {{ course.name }}
            <button
              type="button"
              class="btn text-danger  btn-sm ml-2" 
              style="font-weight: bold;"
              @click="removeFromCart(index)"
            >
              x
            </button>
          </li>
        </ol>
      </div>
  
    
      <div v-if="errorMessage" class="alert alert-danger">
        {{ errorMessage }}
      </div>

      <div v-if="successMessage" class="alert alert-success">
        {{ successMessage }}
      </div>
  
     
      <button
        type="button"
        class="btn btn-success mt-3"
        @click="saveEnrollment"
      >
        Save Enrollment
      </button>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  
  export default {
    data() {
      return {
        students: [],
        courses: [],
        selectedStudent: null, 
        selectedCourse: null,
        cart: [],
        errorMessage: "",
        successMessage: "",
      };
    },
    methods: {
    
      async fetchStudents() {
        try {
          const response = await axios.get("http://127.0.0.1:8000/api/ShowStudent");
          this.students = response.data;
        } catch (error) {
          this.errorMessage = "Unable to fetch students. Please try again later.";
        }
      },
  
     
      async fetchCourses() {
        try {
          const response = await axios.get("http://127.0.0.1:8000/api/ShowCourse");
          this.courses = response.data;
        } catch (error) {
          this.errorMessage = "Unable to fetch courses. Please try again later.";
        }
      },
  
    
      addCourseToCart() {
        if (this.cart.length >= 5) {
          this.errorMessage = "You cannot add more than 5 courses.";
          return;
        }
        if (this.cart.find((course) => course.id === this.selectedCourse.id)) {
          this.errorMessage = "This course is already added.";
          return;
        }
        this.cart.push(this.selectedCourse); 
        this.selectedCourse = null; 
        this.errorMessage = "";
      },
  
      removeFromCart(index) {
        this.cart.splice(index, 1);
      },
  
      async saveEnrollment() {
        if (!this.selectedStudent) {
          this.errorMessage = "Please select a student.";
          return;
        }
        if (this.cart.length === 0) {
          this.errorMessage = "Please add at least one course to the cart.";
          return;
        }
  
        try {
          const response = await axios.post("http://127.0.0.1:8000/api/AddStudentCourse", {
            student_id: this.selectedStudent,
            course_id: this.cart.map((course) => course.id),
          });
          this.successMessage = response.data.success;
          alert(this.successMessage)
          this.errorMessage = "";
          this.resetForm();
        } catch (error) {
          this.errorMessage = error.response?.data?.error || "An error occurred while saving.";
          this.successMessage = "";
        }
      },
  
      
      resetForm() {
        this.selectedStudent = null;
        this.selectedCourse = null;
        this.cart = [];
        this.errorMessage = "";
        this.successMessage = "";
      },
    },
    mounted() {
      this.fetchStudents();
      this.fetchCourses();
    },
  };
  </script>
  
  <style>
  .container {
    max-width: 600px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #f9f9f9;
  }
  
  .form-group {
    margin-bottom: 15px;
  }
  
  .alert {
    margin-top: 10px;
    padding: 10px;
    border-radius: 5px;
  }
  
  .alert-danger {
    color: red;
    background: #f8d7da;
    border: 1px solid #f5c2c7;
  }
  
  .alert-success {
    color: green;
    background: #d4edda;
    border: 1px solid #c3e6cb;
  }
  </style>
  