<?php
$this->extend('layout/main');
$this->section('body');
?>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<h1>Student List</h1>
<a href="<?= site_url('students/create') ?>" class="btn btn-primary">Add Student</a>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Student Name</th>
            <th scope="col">Student Number</th>
            <th scope="col">Student Section</th>
            <th scope="col">Student Courses</th>
            <th scope="col">Student Batch</th>
            <th scope="col">Student Grade Level</th>
            <th scope="col">Student Profile</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($students as $student): ?>
        <tr>
            <td><?= $student['id'] ?></td>
            <td><?= $student['student_name'] ?></td>
            <td><?= $student['student_id'] ?></td>
            <td><?= $student['student_section'] ?></td>
            <td><?= $student['student_course'] ?></td>
            <td><?= $student['student_batch'] ?></td>
            <td><?= $student['student_grade_level'] ?></td>
            <td>
                <img src="<?= site_url('students/profile/' . $student['student_profile']) ?>" alt="Profile Picture"
                    class="img-thumbnail" width="100">
            </td>
            <td>
                <a href="<?= site_url('/students/edit/' . $student['id']) ?>" class="btn btn-warning">Edit</a>
                <form action="<?= site_url('students/delete/' . $student['student_id']) ?>" method="post"
                    class="d-inline">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Are you sure you want to delete this student?')">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>


<?php $this->endSection(); ?>