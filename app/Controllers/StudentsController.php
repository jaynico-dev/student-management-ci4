<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\StudentsModel;

class StudentsController extends BaseController
{
    // This controller handles student-related actions
    public function index()
    {
        $fetchStudent = new StudentsModel();
        $data['students'] = $fetchStudent->findAll();
        return view('students/list', $data);
    }
    // Show the form for creating a new student
    public function createStudent()
    {
        $data['studentNumber'] = '20000_'.uniqid();
        return view('students/add', $data);
    }
    // Store a newly created student in storage
    public function storeStudent() 
    {
        $insertStudents = new StudentsModel();
        
        if ($img = $this->request->getFile('student_profile')) {
            if($img->isValid() && ! $img->hasMoved()) {
                $imageName = $img->getRandomName();
                $img->move(WRITEPATH.'uploads/', $imageName);
            }
        };
        
        $data = array(
            // db fields name                    form fields name
            'student_id' => $this->request->getPost('student_id'),
            'student_name' => $this->request->getPost('student_name'),
            'student_section' => $this->request->getPost('student_section'),
            'student_course' => $this->request->getPost('student_course'),
            'student_batch' => $this->request->getPost('student_batch'),
            'student_grade_level' => $this->request->getPost('student_grade_level'),
            'student_profile' => $imageName
        );

        $insertStudents->insert($data);

        return redirect()->to('/students')->with('success', 'Student added successfully!');
    }
    // Show the form for editing the specified student
    public function editStudent($id)
    {
        $fetchStudent = new StudentsModel();
        $data['student'] = $fetchStudent->where('id', $id)->first();

        return view('students/edit', $data);
    }
    // Update the specified student in storage
    public function updateStudent($id) 
    {
        $updateStudents = new StudentsModel();
        $db = db_connect();

        if ($img = $this->request->getFile('student_profile')) {
            if($img->isValid() && ! $img->hasMoved()) {
                $imageName = $img->getRandomName();
                $img->move(WRITEPATH.'uploads/', $imageName);
                $data['student_profile'] = $imageName;
            }
        }

        if(!empty($_FILES['student_profile']['name'])) {
            $db->query("UPDATE tbl_students SET student_profile = '$imageName' WHERE id = '$id'");
        }

        $data = array(
            'student_name' => $this->request->getPost('student_name'),
            'student_section' => $this->request->getPost('student_section'),
            'student_course' => $this->request->getPost('student_course'),
            'student_batch' => $this->request->getPost('student_batch'),
            'student_grade_level' => $this->request->getPost('student_grade_level'),
        );

        $updateStudents->update($id, $data);

        return redirect()->to('/students')->with('success', 'Student updated successfully!');
    }
    // Remove the specified student from storage
    public function deleteStudent($id)
    {
        
    }

    public function serveImage($filename)
    {
        $path = WRITEPATH . 'uploads/' . $filename;

        if (!is_file($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->response
            ->setHeader('Content-Type', mime_content_type($path))
            ->setHeader('Content-Disposition', 'inline; filename="' . basename($path) . '"')
            ->setBody(file_get_contents($path));
    }
}