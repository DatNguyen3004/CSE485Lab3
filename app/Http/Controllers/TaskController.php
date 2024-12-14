<?php
// app/Http/Controllers/TaskController.php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Hiển thị danh sách các task
    public function index()
    {
        $tasks = Task::all(); // Lấy tất cả các task
        return view('tasks.index', compact('tasks'));
    }

    // Hiển thị form để tạo task mới
    public function create()
    {
        return view('tasks.create');
    }

    // Lưu task mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        // Xử lý dữ liệu từ form và loại bỏ _token
        $data = $request->except('_token');
        
        // Kiểm tra nếu trường 'completed' có trong request, và chuyển nó thành true (1) hoặc false (0)
        $completed = $request->has('completed') ? 1 : 0;

        // Lưu task mới
        Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'long_description' => $request->input('long_description'),
            'completed' => $completed,
        ]);

        return redirect()->route('tasks.index');
    }

    // Hiển thị form để chỉnh sửa một task
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    // Cập nhật task vào cơ sở dữ liệu
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        // Kiểm tra nếu trường 'completed' có trong request, và chuyển nó thành true (1) hoặc false (0)
        $completed = $request->has('completed') ? 1 : 0;

        // Cập nhật task
        $task->update([
            'long_description' => $request->input('long_description'),
            'completed' => $completed,
        ]);

        return redirect()->route('tasks.index');
    }

    // Xóa task khỏi cơ sở dữ liệu
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index');
    }
}

?>