<?php
use Illuminate\Http\Request;
use App\Http\Controllers\AcademicController;
use App\Http\Controllers\ApplicationFileController;
use App\Http\Controllers\ApplicationInternalController;
use App\Http\Controllers\ApplicationsExternalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EducationHistoryController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\LineNotifyController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\ScholarshipCourseController;
use App\Http\Controllers\ScholarshipDocumentController;
use App\Http\Controllers\ScholarshipFileController;
use App\Http\Controllers\ScholarshipHistoryController;
use App\Http\Controllers\ScholarshipQualificationController;
use App\Http\Controllers\ScholarshipTypeController;
use App\Http\Controllers\SiblingController;
use App\Http\Controllers\SouthernLocationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\WorkExperienceController;
use Illuminate\Support\Facades\Route;

Route::post('/login/student', [AuthController::class, 'loginStudent']);
Route::post('/register/student', [StudentController::class, 'store']); // Create a new student
Route::post('/register/academic', [AcademicController::class, 'store']); // Create a new academic
Route::post('/login/academic', [AuthController::class, 'loginAcademic']);

Route::get('/scholarships', [ScholarshipController::class, 'index']);
Route::get('/scholarships/latest', [ScholarshipController::class, 'latest']);
Route::get('/scholarships/{id}', [ScholarshipController::class, 'show']);

// Additional route for downloading the file (if needed)
Route::get('/scholarship-files/{id}/download', [ScholarshipFileController::class, 'download']);

Route::get('/locations', [LocationController::class, 'index']);
Route::get('/southern-locations', [SouthernLocationController::class, 'index']);
Route::get('/districts/{provinceName}', [SouthernLocationController::class, 'getDistricts']);
Route::get('/subdistricts/{districtId}', [SouthernLocationController::class, 'getSubdistricts']);

// Group routes that require authentication
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Routes for Academics
    Route::prefix('academics')->group(function () {
        Route::get('/', [AcademicController::class, 'index']); // Get all academics
        Route::get('/{id}', [AcademicController::class, 'show']); // Get a single academic
        Route::put('/{id}', [AcademicController::class, 'update']); // Update an academic
        Route::delete('/{id}', [AcademicController::class, 'destroy']); // Delete an academic
    });

    // Routes for Students
    Route::prefix('students')->group(function () {
        Route::get('/', [StudentController::class, 'index']); // Get all students
        Route::get('/{id}', [StudentController::class, 'show']); // Get a single student
        Route::put('/{id}', [StudentController::class, 'update']); // Update a student
        Route::delete('/{id}', [StudentController::class, 'destroy']); // Delete a student
    });

    // Routes for Scholarships
    Route::prefix('scholarships')->group(function () {
        Route::post('/', [ScholarshipController::class, 'store']); // Create a new scholarship
        Route::put('/{id}', [ScholarshipController::class, 'update']); // Update a scholarship
        Route::delete('/{id}', [ScholarshipController::class, 'destroy']); // Delete a scholarship
        Route::get('/{id}/namefiles', [ScholarshipController::class, 'getFiles']);
        Route::get('/type/{type}', [ScholarshipController::class, 'searchByType']); // Search by type
    });

    // Routes for Application Files
    Route::prefix('application-files')->group(function () {
        Route::get('/', [ApplicationFileController::class, 'index']); // Get all application files
        Route::get('/{id}', [ApplicationFileController::class, 'show']); // Get a single application file
        Route::post('/', [ApplicationFileController::class, 'store']); // Create a new application file
        Route::put('/{id}', [ApplicationFileController::class, 'update']); // Update an application file
        Route::delete('/{id}', [ApplicationFileController::class, 'destroy']); // Delete an application file
    });

    // Routes for Scholarship Files
    Route::prefix('scholarship-files')->group(function () {
        Route::get('/', [ScholarshipFileController::class, 'index']); // Get all scholarship files
        Route::get('/{id}', [ScholarshipFileController::class, 'show']); // Get a single scholarship file
        Route::post('/', [ScholarshipFileController::class, 'store']); // Create a new scholarship file
        Route::post('/{id}', [ScholarshipFileController::class, 'update']); // Update an existing scholarship file
        Route::delete('/{id}', [ScholarshipFileController::class, 'destroy']); // Delete a scholarship file
    });

    // Routes for Scholarship History
    Route::prefix('scholarship-histories')->group(function () {
        Route::get('/', [ScholarshipHistoryController::class, 'index']); // Get all scholarship histories
        Route::get('/{id}', [ScholarshipHistoryController::class, 'show']); // Get a single scholarship history
        Route::post('/', [ScholarshipHistoryController::class, 'store']); // Create a new scholarship history
        Route::put('/{id}', [ScholarshipHistoryController::class, 'update']); // Update a scholarship history
        Route::delete('/{id}', [ScholarshipHistoryController::class, 'destroy']); // Delete a scholarship history
    });

// Routes for Scholarship Qualifications
    Route::prefix('scholarship-qualifications')->group(function () {
        Route::get('/', [ScholarshipQualificationController::class, 'index']); // Get all scholarship qualifications
        Route::get('/{id}', [ScholarshipQualificationController::class, 'show']); // Get a single scholarship qualification
        Route::post('/', [ScholarshipQualificationController::class, 'store']); // Create new scholarship qualifications
        Route::put('/{id}', [ScholarshipQualificationController::class, 'update']); // Update scholarship qualifications
        Route::delete('/{id}', [ScholarshipQualificationController::class, 'destroy']); // Delete a scholarship qualification
    });

    // Routes for Scholarship Courses
    Route::prefix('scholarship-courses')->group(function () {
        Route::get('/', [ScholarshipCourseController::class, 'index']); // Get all scholarship courses
        Route::get('/{id}', [ScholarshipCourseController::class, 'show']); // Get a single scholarship course
        Route::post('/', [ScholarshipCourseController::class, 'store']); // Create a new scholarship course
        Route::put('/{id}', [ScholarshipCourseController::class, 'update']); // Update a scholarship course
        Route::delete('/{id}', [ScholarshipCourseController::class, 'destroy']); // Delete a scholarship course
    });

    // Routes for Scholarship Documents
    Route::prefix('scholarship-documents')->group(function () {
        Route::get('/', [ScholarshipDocumentController::class, 'index']); // Get all scholarship documents
        Route::get('/{id}', [ScholarshipDocumentController::class, 'show']); // Get a single scholarship document
        Route::post('/', [ScholarshipDocumentController::class, 'store']); // Create new scholarship documents
        Route::put('/{id}', [ScholarshipDocumentController::class, 'update']); // Update a scholarship document
        Route::delete('/{id}', [ScholarshipDocumentController::class, 'destroy']); // Delete a scholarship document
    });

    // Routes for Scholarship Types
    Route::prefix('scholarship-types')->group(function () {
        Route::get('/', [ScholarshipTypeController::class, 'index']); // Get all scholarship types
        Route::get('/{id}', [ScholarshipTypeController::class, 'show']); // Get a single scholarship type
        Route::post('/', [ScholarshipTypeController::class, 'store']); // Create a new scholarship type
        Route::put('/{id}', [ScholarshipTypeController::class, 'update']); // Update a scholarship type
        Route::delete('/{id}', [ScholarshipTypeController::class, 'destroy']); // Delete a scholarship type
    });

    // Routes for Guardians
    Route::prefix('guardians')->group(function () {
        Route::get('/', [GuardianController::class, 'index']); // Get all guardians
        Route::get('/{id}', [GuardianController::class, 'show']); // Get a single guardian
        Route::post('/', [GuardianController::class, 'store']); // Create a new guardian
        Route::put('/{id}', [GuardianController::class, 'update']); // Update a guardian
        Route::delete('/{id}', [GuardianController::class, 'destroy']); // Delete a guardian
    });

    // Routes for Siblings
    Route::prefix('siblings')->group(function () {
        Route::get('/', [SiblingController::class, 'index']); // Get all siblings
        Route::get('/{id}', [SiblingController::class, 'show']); // Get a single sibling
        Route::post('/', [SiblingController::class, 'store']); // Create a new sibling
        Route::put('/{id}', [SiblingController::class, 'update']); // Update a sibling
        Route::delete('/{id}', [SiblingController::class, 'destroy']); // Delete a sibling
    });

    // Routes for Education Histories
    Route::prefix('education-histories')->group(function () {
        Route::get('/', [EducationHistoryController::class, 'index']); // Get all education histories
        Route::get('/{id}', [EducationHistoryController::class, 'show']); // Get a single education history
        Route::post('/', [EducationHistoryController::class, 'store']); // Create a new education history
        Route::put('/{id}', [EducationHistoryController::class, 'update']); // Update an education history
        Route::delete('/{id}', [EducationHistoryController::class, 'destroy']); // Delete an education history
    });

    // Routes for Work Experiences
    Route::prefix('work-experiences')->group(function () {
        Route::get('/', [WorkExperienceController::class, 'index']); // Get all work experiences
        Route::get('/{id}', [WorkExperienceController::class, 'show']); // Get a single work experience
        Route::post('/', [WorkExperienceController::class, 'store']); // Create a new work experience
        Route::put('/{id}', [WorkExperienceController::class, 'update']); // Update a work experience
        Route::delete('/{id}', [WorkExperienceController::class, 'destroy']); // Delete a work experience
    });

// Routes for ApplicationInternals
    Route::prefix('applications-internal')->group(function () {
        Route::get('/', [ApplicationInternalController::class, 'index']); // Get all applications
        Route::post('/', [ApplicationInternalController::class, 'store']); // Create a new application
        Route::get('/{id}', [ApplicationInternalController::class, 'show']); // Get a single application
        Route::put('/{id}', [ApplicationInternalController::class, 'update']); // Update an application
        Route::delete('/{id}', [ApplicationInternalController::class, 'destroy']); // Delete an application
    });

    // Routes for Applications External
    Route::prefix('applications-external')->group(function () {
        Route::get('/', [ApplicationsExternalController::class, 'index']); // Get all external applications
        Route::post('/', [ApplicationsExternalController::class, 'store']); // Create a new external application
        Route::get('/{id}', [ApplicationsExternalController::class, 'show']); // Get a single external application
        Route::put('/{id}', [ApplicationsExternalController::class, 'update']); // Update an external application
        Route::delete('/{id}', [ApplicationsExternalController::class, 'destroy']); // Delete an external application
        Route::get('/{id}/download/{fileName}', [ApplicationsExternalController::class, 'downloadFile']);
    });

    // Routes for Notifications
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index']); // Get all notifications
        Route::post('/', [NotificationController::class, 'store']); // Create a new notification
        Route::get('/{id}', [NotificationController::class, 'show']); // Get a single notification
        Route::put('/{id}', [NotificationController::class, 'update']); // Update a notification
        Route::delete('/{id}', [NotificationController::class, 'destroy']); // Delete a notification
    });

    // Routes for Reports
    Route::prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index']); // Get all reports
        Route::post('/', [ReportController::class, 'store']); // Create a new report
        Route::get('/{id}', [ReportController::class, 'show']); // Get a single report
        Route::put('/{id}', [ReportController::class, 'update']); // Update a report
        Route::delete('/{id}', [ReportController::class, 'destroy']); // Delete a report
    });

    // Routes for Line Notify
    Route::prefix('line-notifies')->group(function () {
        Route::get('/', [LineNotifyController::class, 'index']); // Get all line notifies
        Route::post('/', [LineNotifyController::class, 'store']); // Create a new line notify
        Route::get('/{id}', [LineNotifyController::class, 'show']); // Get a single line notify
        Route::put('/{id}', [LineNotifyController::class, 'update']); // Update a line notify
        Route::delete('/{id}', [LineNotifyController::class, 'destroy']); // Delete a line notify
    });
    Route::options('{any}', function(Request $request) {
    return response()->json(['status' => 'OK'], 200)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
        ->header('Access-Control-Allow-Credentials', 'true');
})->where('any', '.*');
});
