<?php

$this->extend('layout/main');
$this->section('body');

?>

<h1>Add Student</h1>
<form method="POST" action="/students/store" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="studentName" class="form-label">Student Name</label>
        <input type="text" class="form-control" id="student_name" name="student_name" required>
    </div>

    <div class="mb-3">
        <label for="student_id" class="form-label">Student Number</label>
        <input type="text" class="form-control" id="student_id" name="student_id" value=<?= $studentNumber ?> readonly>
    </div>

    <div class="mb-3">
        <label for="student_section" class="form-label">Student Section</label>
        <input type="text" class="form-control" id="student_section" name="student_section" required>
    </div>

    <div class="mb-3">
        <label for="student_course" class="form-label">Student Course</label>
        <input type="text" class="form-control" id="student_course" name="student_course" required>
    </div>

    <div class="mb-3">
        <label for="student_batch" class="form-label">Student Batch</label>
        <input type="text" class="form-control" id="student_batch" name="student_batch" required>
    </div>

    <div class="mb-3">
        <label for="student_grade_level" class="form-label">Student Grade Level</label>
        <input type="text" class="form-control" id="student_grade_level" name="student_grade_level" required>
    </div>

    <div class="mb-3">
        <label for="student_profile" class="form-label">Student Profile (Photo)</label>
        <input type="file" class="form-control" id="student_profile" name="student_profile" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>


<?php $this->endSection(); ?>