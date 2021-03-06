<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CompleteApplicationRequest;
use App\Http\Requests\User\DropDownRequest;
use App\Http\Requests\User\EditApplicationRequest;
use App\Http\Traits\Confirms;
use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\DB;
use App\Models\School;
use App\Models\Vacancy;


class ApplicationController extends Controller
{
    use Confirms;

    public function showCompleteApplicationForm()
    {

        return view('dashboard.user.application.complete');

    }

    public function saveAdditinalApplicationDetails(CompleteApplicationRequest $request)
    {
        Application::create([
            'user_id'            => auth()->user()->id,
            'id_number'          => $request->id_number,
            'place_of_birth'     => $request->place_of_birth,
            'year_of_birth'      => $request->year_of_birth,
            'place_of_residence' => $request->place_of_residence,
            'education_level'    => $request->education_level,
            'year_finished_sec'  => $request->year_finished_sec,
            'sec_school'         => $request->sec_school,
            'index_no'           => $request->index_no,
            'higher_inst'        => $request->higher_inst,
            'course'             => $request->course,
            'subject_one'        => $request->subject_one,
            'subject_two'        => $request->subject_two,
            'first_reference'    => $request->first_reference,
            'second_reference'   => $request->second_reference,
            'next_of_kin_name'   => $request->next_of_kin_name,
            'next_of_kin_phone'  => $request->next_of_kin_phone,
            'relationship'       => $request->relationship,
        ]);

        //show success message and redirect to home
        return redirect('home')->with(session()->flash('success-message', ['Application Successfull ']));

    }

    public function showApplicationDetails()//show details for a registered user
    {
//        $b=$this->emailPhone();
        return view('dashboard.user.application.details', [
            'user' => auth()->user(),
        ]);
    }

    public function editApplicationDetails()
    {
        // $this->saveEditedApplicationDetails($id);
        return view('dashboard.user.application.edituserdetails');


    }

    public function saveEditedApplicationDetails(EditApplicationRequest $request)
    {
        $apps = Application::find(auth()->user()->id);
        $apps->update([
            'place_of_birth'     => $request->place_of_birth,
            'year_of_birth'      => $request->year_of_birth,
            'place_of_residence' => $request->place_of_residence,
            'education_level'    => $request->education_level,
            'year_finished_sec'  => $request->year_finished_sec,
            'sec_school'         => $request->sec_school,
            'index_no'           => $request->index_no,
            'higher_inst'        => $request->higher_inst,
            'course'             => $request->course,
            'subject_one'        => $request->subject_one,
            'subject_two'        => $request->subject_two,
            'first_reference'    => $request->first_reference,
            'second_reference'   => $request->second_reference,
            'next_of_kin_name'   => $request->next_of_kin_name,
            'next_of_kin_phone'  => $request->next_of_kin_phone,
            'relationship'       => $request->relationship,
        ]);

    }

    public function showSchools()
    {
        return view('dashboard.user.vacancy.allvacancy', [
            'schools' => School::paginate(10),
        ]);
    }

    public function showVacancies($id)
    {
        return view('dashboard.user.vacancy.schoolvacancy', [
            'vacancies' => Vacancy::where('school_id', $id)->paginate(10),
        ]);
    }

    //get vacancy dropdown
    public function county()
    {
        return view('dashboard.user.vacancy.vacancydropdown');
    }


    public function vacancybycounty(Request $request)
    {
//        dd($request->toArray());
        return view('dashboard.user.vacancy.vacancybycounty', [
            'counties' => School::where('location', $request->counties)->paginate(10),
        ]);
    }

    public function vacancybysubjects()
    {
        return view('dashboard.user.vacancy.subjectsvacancy', [
            'subjects' => Vacancy::where('subjects', auth()->user()->application->subject_one)
                ->orwhere('subjects', auth()->user()->application->subject_two)->paginate(10),
        ]);
    }

    public function vacancybyschool($id)
    {
        return view('dashboard.user.vacancy.vacancybyschool', [
            'schools' => Vacancy::where('school_id', $id)->paginate(10),
        ]);
    }

}
