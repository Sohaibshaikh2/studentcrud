<script setup lang="ts">
import { RouterLink } from 'vue-router';
</script>

<template>
   <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <RouterLink class="nav-link" aria-current="page" to="/">Home</RouterLink>
        </li>
        <li class="nav-item">
          <RouterLink class="nav-link" to="/student/insert">Enroll Student</RouterLink>
        </li>

        <li class="nav-item">
          <RouterLink class="nav-link" to="/student/add">Add Student</RouterLink>
        </li>
    
        <li class="nav-item">
          <RouterLink class="nav-link" to="/courses/index">Courses</RouterLink>
        </li>
    
     
      </ul>
   
    </div>
  </div>
</nav>
   <router-view/>
</template>