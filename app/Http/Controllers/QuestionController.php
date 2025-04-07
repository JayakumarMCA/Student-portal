<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Option;
use App\Models\CourseMaster;
use Illuminate\Http\Request;
use App\helpers\Reply;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    // Display a listing of the questions
    public function index(Request $request)
    {
        $query = Question::with('course');

        if ($request->filled('question')) {
            $query->where('text', 'like', '%' . $request->question . '%');
        }
    
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }
    
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
    
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
    
        $questions  = $query->get();
        $courses    = CourseMaster::pluck('title', 'id');
        return view('admin.questions.index', compact('questions','courses'));
    }

    // Show the form for creating a new question
    public function create()
    {
        $courses    = CourseMaster::pluck('title', 'id');
        return view('admin.questions.create',compact('courses'));
    }

    // Store a newly created question in storage
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_type' => 'required|in:1,2',
            'course_id' => 'required|exists:course_masters,id',
            'is_correct' => 'required',
            'question' => [
                'required',
                function ($attribute, $value, $fail) {
                    $comment = trim(str_replace('<p><br></p>', '', $value));
                    if ($comment === '') {
                        $fail('The question field is required.');
                    }
                },
            ],
            'option.*' => [
                'required_if:option_file.*,null',
                function ($attribute, $value, $fail) {
                    $comment = trim(str_replace('<p><br></p>', '', $value));
                    if ($comment === '') {
                        $fail('All option fields are required.');
                    }
                },
            ],
        ], [
            'question_type.required' => 'Question type is required.',
            'question_type.in' => 'Invalid question type.',
            'course_id.required' => 'Course is required.',
            'course_id.exists' => 'Selected course does not exist.',
            'is_correct.required' => 'Please select the correct answer.',
            'option.*.required_if' => 'All option fields are required.',
        ]);
        $hasCorrect = false;
        if (isset($request->option) && is_array($request->option)) {
            foreach ($request->option as $index => $value) {
                if ($request->is_correct == $index) {
                    $hasCorrect = true;
                    break;
                }
            }
        }
        if ($validator->fails() || !$hasCorrect) {
            if (!$hasCorrect) {
                $validator->errors()->add('is_correct', 'Please select the correct answer.');
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $question                       =   new Question();
        $question->question_text        =   $request->question ?? '';
        $question->question_type        =   $request->question_type ?? '';
        $question->course_id            =   $request->course_id ?? '';
        $question->save();
        $questionId                     =   $question->id;
        if (isset($request->option) && count($request->option) > 0) {
            for ($i = 1; $i <= $request->option_count; $i++) {
                $answer                 =   new Option();
                $answer->question_id    =   $questionId;
                $answer->option_text    =   $request->option[$i];
                $answer->is_correct     =   ($request->is_correct == $i) ? 1 : 0;
                $answer->save();
            }
        }
        return redirect()->route('questions.index')->with('success', 'Question created successfully.');
    }

    // Display the specified question
    public function show(Question $question)
    {
        return view('questions.show', compact('question'));
    }

    // Show the form for editing the specified question
    public function edit(Question $question)
    {
        $courses        =   CourseMaster::pluck('title', 'id');
        $careeranswers  =   Option::where('question_id',$question->id)->get();
        return view('admin.questions.edit', compact('question','courses','careeranswers'));
    }

    // Update the specified question in storage
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'question_type' => 'required|in:1,2',
            'course_id' => 'required|exists:course_masters,id',
            'is_correct' => 'required',
            'question' => [
                'required',
                function ($attribute, $value, $fail) {
                    $comment = trim(str_replace('<p><br></p>', '', $value));
                    if ($comment === '') {
                        $fail('The question field is required.');
                    }
                },
            ],
            'option.*' => [
                'required_if:option_file.*,null',
                function ($attribute, $value, $fail) {
                    $comment = trim(str_replace('<p><br></p>', '', $value));
                    if ($comment === '') {
                        $fail('All option fields are required.');
                    }
                },
            ],
        ], [
            'question_type.required' => 'Question type is required.',
            'question_type.in' => 'Invalid question type.',
            'course_id.required' => 'Course is required.',
            'course_id.exists' => 'Selected course does not exist.',
            'is_correct.required' => 'Please select the correct answer.',
            'option.*.required_if' => 'All option fields are required.',
        ]);
        $hasCorrect = false;
        if (isset($request->option) && is_array($request->option)) {
            foreach ($request->option as $index => $value) {
                if ($request->is_correct == $index) {
                    $hasCorrect = true;
                    break;
                }
            }
        }
        if ($validator->fails() || !$hasCorrect) {
            if (!$hasCorrect) {
                $validator->errors()->add('is_correct', 'Please select the correct answer.');
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $question                       =   Question::findOrFail($id);
        $question->question_text        =   $request->question;
        $question->question_type        =   $request->question_type;
        $question->course_id            =   $request->course_id;
        $question->save();
        if (isset($request->option) && count($request->option) > 0) {
            Option::where('question_id', $id)->delete();
            for ($i = 1; $i <= $request->option_count; $i++) {
                $answer = new Option();
                $answer->question_id    =   $id;
                $answer->option_text    =   $request->option[$i];
                $answer->is_correct     =   ($request->is_correct == $i) ? 1 : 0;
                $answer->save();
            }
        }

        return redirect()->route('questions.index')->with('success', 'Question updated successfully.');
    }

    // Remove the specified question from storage
    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('questions.index')->with('success', 'Question deleted successfully.');
    }
    public function getOptions($id)
    {
        if ($id == 1) {
            $this->view = 'admin.questions.option-types.true_or_false';
        } else {
            $this->view = 'admin.questions.option-types.mcq';
        }
    
        if (request()->ajax()) {
            $data = [];
    
            $html = view($this->view, $data)->render();
            return Reply::dataOnly(['status' => 'success', 'html' => $html]);
        }
    }
    public function mcqOptionHtml($count)
    {
        $this->view = 'admin.questions.option';
        $this->rowCount = $count;
        if (request()->ajax()) {
            $data = ['rowCount' => $this->rowCount];
            $html = view($this->view, $data)->render();
            return response()->json(['status' => 'success', 'html' => $html]);
        }
        return view($this->view, ['rowCount' => $this->rowCount]);
    }
}
