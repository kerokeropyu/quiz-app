<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\Quiz;
use App\Models\Option;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, string $categoryId)
    {
        return view('admin.quizzes.create', compact('categoryId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuizRequest $request, string $categoryId)
    {
        $quiz = new Quiz();
        $quiz->category_id = $categoryId;
        $quiz->question = $request->question;
        $quiz->explanation = $request->explanation;
        $quiz->save();

        $options = [
            ['quiz_id' => $quiz->id, 'content' => $request->content1, 'is_correct' => $request->isCorrect1],
            ['quiz_id' => $quiz->id, 'content' => $request->content2, 'is_correct' => $request->isCorrect2],
            ['quiz_id' => $quiz->id, 'content' => $request->content3, 'is_correct' => $request->isCorrect3],
            ['quiz_id' => $quiz->id, 'content' => $request->content4, 'is_correct' => $request->isCorrect4],
        ];

        foreach ($options as $option) {
            $newOption = new Option();
            $newOption->quiz_id = $option['quiz_id'];
            $newOption->content = $option['content'];
            $newOption->is_correct = $option['is_correct'];
            $newOption->save();
        }

        return redirect()->route('admin.categories.show', ['categoryId' => $categoryId]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $categoryId, string $quizId)
    {

        $quiz = Quiz::with('category', 'options')->findOrFail($quizId);
        return view('admin.quizzes.edit', compact('quiz'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuizRequest $request, string $categoryId, string $quizId)
    {
 
        $options = [
            ['option_id' => $request->optionId1, 'content' => $request->content1, 'is_correct' => $request->isCorrect1],
            ['option_id' => $request->optionId2, 'content' => $request->content2, 'is_correct' => $request->isCorrect2],
            ['option_id' => $request->optionId3, 'content' => $request->content3, 'is_correct' => $request->isCorrect3],
            ['option_id' => $request->optionId4, 'content' => $request->content4, 'is_correct' => $request->isCorrect4],
        ];
        // dd($options);
        $quiz = Quiz::findOrFail($quizId);
        $quiz->question = $request->question;
        $quiz->explanation = $request->explanation;
        $quiz->save();

        foreach ($options as $option) {
            $updateOption = Option::findOrFail($option['option_id']);
            $updateOption->content = $option['content'];
            $updateOption->is_correct = $option['is_correct'];
            $updateOption->save();
        }

        return redirect()->route('admin.categories.show', ['categoryId' => $categoryId]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
