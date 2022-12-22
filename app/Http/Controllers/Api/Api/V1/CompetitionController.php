<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassRoomResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CompetitionResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\TeacherResource;
use App\Http\Resources\UserResource;
use App\Models\ClassRoom;
use App\Models\CompetitionRequest;
use App\Models\CompetitionParticipant;
use App\Models\Course;
use App\Models\Question;
use App\Models\Competition;
use App\Models\CompetitionQuestion;
use App\Models\Section;
use App\Models\City;
use App\Models\Subject;
use App\Models\User;
use App\Models\CompetitionAnswer;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use GLibs\HTTP\Response;

class CompetitionController extends Controller
{
    private $version = '1.0';

    public function index(Request $request)
    {
//        if($request->header('mobile_version') != '1.0.1') {
//            return apiResponse(false, null, 'Version Not Identical.', null, 400);
//        }
        $userId = auth()->id();
        $items = Competition::leftjoin('subjects', 'subjects.id', '=', 'competitions.subject_id')
                            ->join('competition_participants', 'competitions.id', '=', 'competition_participants.competition_id')
                            ->where(function ($query) use ($userId) {
                                $query->where('participant1_id', $userId)
                                    ->orwhere('participant2_id', $userId);
                            })
                            //->join('courses', 'subjects.id', '=', 'courses.subject_id')
                            //->join('enrollments', 'enrollments.course_id', '=', 'courses.id')
                            //->where('enrollments.user_id', $userId)
                            ->select('competitions.*', 'participant1_id', 'result1', 'result1_date', 'participant2_id', 'result2', 'result2_date', 'winner')
                            //->with('user1.user')
                            ->paginate(20);
        return CompetitionResource::collection($items)->additional([
            'success' => true,
            'message' => null,
            'errors' => null,
            'status'  => 200
        ]);
    }


    public function show(Request $request)
    {
//        if($request->header('mobile_version') != '1.0.1') {
//            return apiResponse(false, null, 'Version Not Identical.', null, 400);
//        }
        $userId = auth()->id();
        $item = Competition::leftjoin('subjects', 'subjects.id', '=', 'competitions.subject_id')
                            ->join('competition_participants', 'competitions.id', '=', 'competition_participants.competition_id')
                            ->where(function ($query) use ($userId) {
                                $query->where('participant1_id', $userId)
                                    ->orwhere('participant2_id', $userId);
                            })
                            ->where('competition_participants.is_closed', 0)
                            ->whereDate('competitions.date', Carbon::today())
                            ->select('competitions.*', 'participant1_id', 'result1', 'result1_date', 'participant2_id', 'result2', 'result2_date', 'winner')
                            ->first();
        if (!$item) {
            return apiResponse(false, null, __('api.not_found'), null, 404);
        }
        $questionsIds = CompetitionQuestion::where('competition_id', $item->id)->pluck('question_id')->toArray();
        $questions    = Question::with('options')->whereIn('id', $questionsIds)->get();
        //$item['answers_marks'] = $myAnswers->sum('marks') ?? 0;
        $item['questions']  = $questions;
        return new CompetitionResource($item);
    }


    public function requestCompetition(Request $request, $id)
    {
//        if($request->header('mobile_version') != '1.0.1') {
//            return apiResponse(false, null, 'Version Not Identical.', null, 400);
//        }
        $item = Competition::find($id);
        if (!$item) {
            return apiResponse(false, null, __('api.not_found'), null, 404);
        }
        $userId = auth()->id();
        $competitionRequest = CompetitionRequest::where('user_id', $userId)->where('competition_id', $item->id)->first();
        if ($competitionRequest) {
            return apiResponse(false, null, __('api.entered_before'), null, 400);
        }
        $competitionRequest = new CompetitionRequest();
        $competitionRequest->user_id = $userId;
        $competitionRequest->competition_id = $item->id;
        $competitionRequest->save();
        return apiResponse(true, null, null, null, 200);
    }


    public function storeResult(Request $request, $id)
    {
//        if($request->header('mobile_version') != '1.0.1') {
//            return apiResponse(false, null, 'Version Not Identical.', null, 400);
//        }
        $validate = array(
            'result' => 'required',
        );
        $validatedData = Validator::make($request->all(), $validate);
        if ($validatedData->fails()) {
            return apiResponse(false, null, __('api.validation_error'), $validatedData->errors()->all(), 422);
        }
        $userId = auth()->id();
        $item = Competition::leftjoin('subjects', 'subjects.id', '=', 'competitions.subject_id')
             ->join('competition_participants', 'competitions.id', '=', 'competition_participants.competition_id')
            ->whereDate('competitions.date', Carbon::today())
            ->where(function ($query) use ($userId) {
                $query->where('participant1_id', $userId)
                      ->orwhere('participant2_id', $userId);
            })
            ->select('competitions.*', 'participant1_id', 'result1', 'result1_date', 'participant2_id', 'result2', 'result2_date', 'winner', 'competition_participants.id as competition_participant_id')
            ->where('competitions.id', $id)
            ->first();

        if (!$item) {
            return apiResponse(false, null, __('api.not_found'), null, 404);
        }

        $competitionParticipant = CompetitionParticipant::find($item->competition_participant_id);
        if ($competitionParticipant->is_closed == 1) {
            return apiResponse(false, null, __('api.competition_cancelled'), null, 400);
        }
        if ($competitionParticipant->participant1_id == $userId) {
            if ($competitionParticipant->result1_date != null) {
                return apiResponse(false, null, __('api.sent_before'), null, 400);
            }
            $competitionParticipant->result1 = $request->result;
            $competitionParticipant->result1_date = now();
        } elseif ($competitionParticipant->participant2_id == $userId) {
            if ($competitionParticipant->result2_date != null) {
                return apiResponse(false, null, __('api.sent_before'), null, 400);
            }
            $competitionParticipant->result2 = $request->result;
            $competitionParticipant->result2_date = now();
        }

        if ($competitionParticipant->save()) {
            if ($competitionParticipant->result1_date != null && $competitionParticipant->result2_date != null) {
                if ($competitionParticipant->result1 > $competitionParticipant->result2) {
                    $competitionParticipant->winner = $competitionParticipant->participant1_id;
                } else {
                    $competitionParticipant->winner = $competitionParticipant->participant2_id;
                }
                $competitionParticipant->is_closed = 1;
                $competitionParticipant->save();
            }
            return apiResponse(true, null, null, null, 200);
        }
        return apiResponse(false, null, null, null, 400);
    }


    public function storeAnswers(Request $request, $id)
    {
//        if($request->header('mobile_version') != '1.0.1') {
//            return apiResponse(false, null, 'Version Not Identical.', null, 400);
//        }
        $validate = array(
            'answers' => 'required',
        );
        $validatedData = Validator::make($request->all(), $validate);
        if ($validatedData->fails()) {
            return apiResponse(false, null, __('api.validation_error'), $validatedData->errors()->all(), 422);
        }
        $item = Competition::find($id);
        if (!$item) {
            return apiResponse(false, null, __('api.not_found'), null, 404);
        }
        $userId = auth()->id();
        $myAnswers = CompetitionAnswer::where('user_id', $userId)->where('competition_id', $id)->count();
        if ($myAnswers > 0) {
            return apiResponse(false, null, __('api.answered_before'), null, 404);
        }
        $arr =[];
        $questionsIds = CompetitionQuestion::where('competition_id', $id)->pluck('question_id')->toArray();
        $questions    = Question::whereIn('id', $questionsIds)->get();

        foreach ($request->answers as $answer) {
            $question  = $questions->where('id', $answer['question_id'])->first();
            $isCorrect = $question->correct == $answer['answer'] ? true : false;
            $arr =[
                'user_id'    => $userId,
                'competition_id' => $id,
                'question_id' => $answer['question_id'],
                'answer'      => $answer['answer'],
                'is_correct'  => $isCorrect,
                'marks'       => $isCorrect ? $question['marks'] : 0,
            ];
        }
        if (count($arr) > 0) {
            CompetitionAnswer::insert($arr);
            return apiResponse(true, null, null, null, 200);
        }
    }


    public function approve(Request $request, $id)
    {
//        if($request->header('mobile_version') != '1.0.1') {
//            return apiResponse(false, null, 'Version Not Identical.', null, 400);
//        }
        $item = Competition::find($id);
        if (!$item) {
            return apiResponse(false, null, __('api.not_found'), null, 404);
        }
        if ($item->user_id1 == auth()->id()) {
            $item->approve1 = 1;
        } else {
            $item->approve2 = 1;
        }
        $item->save();
        return apiResponse(true, null, null, null, 200);
    }
}
