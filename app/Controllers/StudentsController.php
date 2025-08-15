<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\StudentsModel;

class StudentsController extends BaseController
{
    // LIST - Display all students
    public function index()
    {
        $fetchStudent = new StudentsModel();
        $data['students'] = $fetchStudent->findAll();
        return view('students/list', $data);
    }
    // LIST - Create a new student
    public function createStudent()
    {
        $data['studentNumber'] = '20000_'.uniqid();
        return view('students/add', $data);
    }
    // ADD
    public function storeStudent() 
    {
        $insertStudents = new StudentsModel();
        $imageName = null;
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
    // EDIT
    public function editStudent($id)
    {
        $fetchStudent = new StudentsModel();
        $data['student'] = $fetchStudent->where('id', $id)->first();

        return view('students/edit', $data);
    }
    // UPDATE
    public function updateStudent($id) 
    {
        $updateStudents = new StudentsModel();
        $student = $updateStudents->find($id);
        $db = db_connect();

        // Check if a new image file is uploaded
        if ($img = $this->request->getFile('student_profile')) {
            if($img->isValid() && ! $img->hasMoved()) {
                $imageName = $img->getRandomName();
                $img->move(WRITEPATH.'uploads/', $imageName);
                $data['student_profile'] = $imageName;
            }

            $this->deleteImageFile($student['student_profile']);
        }

        // Update the student profile image if a new file is uploaded
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
    // DELETE
    public function deleteStudent($id)
    {
        $model = new StudentsModel();
        $student = $model->find($id);

        if ($student) {
            // Delete image first
            $this->deleteImageFile($student['student_profile']);
            // Delete record
            $model->delete($id);
            return redirect()->to('/students')->with('success', 'Student deleted successfully!');
        }

        return redirect()->to('/students')->with('error', 'Student not found!');
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

    private function deleteImageFile($filename)
    {
        $imagePath = WRITEPATH . 'uploads/' . $filename;
        if (is_file($imagePath)) {
            unlink($imagePath);
            return true;
        }
        return false;
    }
}