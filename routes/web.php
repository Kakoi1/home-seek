<?php

use App\Http\Controllers\GoogleController;
use App\Models\Dorm;
use Chatify\ChatifyMessenger;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotifyController;
use App\Http\Controllers\MessageController;


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/managepage/user', [AdminController::class, 'manageUsers'])->name('admin.manageuser');
    Route::get('/managepage/property', [AdminController::class, 'manageProp'])->name('admin.manageProp');
    Route::post('/admin/dorms/approve', [AdminController::class, 'approveDorm'])->name('admin.approveDorm');
    Route::delete('/admin/dorms/{id}', [AdminController::class, 'deleteDorm'])->name('admin.deleteDorm');
    Route::post('/approve-verification/{id}', [AdminController::class, 'approve'])->name('verification.approve');
    Route::post('/reject-verification/{id}', [AdminController::class, 'reject'])->name('verification.reject');
    Route::post('/activate-user/{id}', [AdminController::class, 'activate'])->name('user.activate');
    Route::post('/deactivate-user/{id}', [AdminController::class, 'deactivate'])->name('user.deactivate');
    Route::put('/managepage/property{id}/deactivate', [AdminController::class, 'deactivateProperty'])->name('admin.deactivateProperty');
    Route::post('/warn-user/{id}', [AdminController::class, 'userwarn'])->name('user.warn');
    Route::get('/reports', function () {
        return view('admin.report'); // Path to your Blade file
    })->name('reports.view');
    Route::post(' /reports/{id}/action', [AdminController::class, 'updateStatus']);

    Route::get('/reports/fetch', [AdminController::class, 'fetchReports'])->name('reports.fetch');
    Route::get('/properties/{id}/details', [AdminController::class, 'show']);


});
Route::get('/yawa', function () {
    return view('dorm');
})->name('dds');

Route::get('/', function () {

    // Fetch dorms with their average rating and order by the highest
    $topRatedDorms = Dorm::with('reviews') // Load reviews relationship
        ->withAvg('reviews', 'rating') // Calculate average rating
        ->orderByDesc('reviews_avg_rating') // Order by the average rating
        ->limit(6) // Limit to 6 dorms
        ->get();

    // Pass the dorms to the view
    return view('index', compact('topRatedDorms'));


})->name('index');

Auth::routes();
Route::get('/test-upload', [HomeController::class, 'showUploadForm'])->name('test.upload.form');
Route::post('/category/store', [HomeController::class, 'upload'])->name('test.upload');
Route::post('/login', [Controller::class, 'login'])->name('login');
Route::post('/register', [Controller::class, 'register'])->name('register');


Route::controller(GoogleController::class)->group(function () {
    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});

Route::controller(Controller::class)->group(function () {
    Route::get('auth/facebook', 'redirectToFacebook')->name('auth.facebook');
    Route::get('auth/facebook/callback', 'handleFacebookCallback');
});

Route::get('/rent-form/{room}', [RoomController::class, 'createRentForm'])
    ->name('rent.form')
    ->middleware('signed');
Route::post('/collect-email-phone', [Controller::class, 'collectEmailPhone'])->name('collect.email.phone');
Route::post('/verify-email', [Controller::class, 'verifyEmail'])->name('verify.email');




Route::get('/send-email/{user}/{action}', [Controller::class, 'redirectEmail'])->name('send.email');
Route::get('/resend/{user}', [Controller::class, 'reSend'])->name('resend.code');
Route::get('/upload', function () {
    return view('upload_documents');
})->name('dds');
// Middleware group for authenticated users
Route::group(['middleware' => ['auth', 'email.verified']], function () {

    Route::group(['middleware' => ['auth', 'owner.verified']], function () {

        Route::get('/home', [DormController::class, 'index'])->name('home');
        Route::get('/dorms', [DormController::class, 'index'])->name('dorm');
        Route::get('/dorms/{id}', [DormController::class, 'show'])->name('dorms.posted');
        Route::get('/user-data/{id}', [DormController::class, 'getUserData']);


        Route::post('/get-coor', [Controller::class, 'getCoor'])->name('get-coor');
        Route::post('/savedorm', [DormController::class, 'saveDorm'])->name('savedorm');
        Route::get('/showdorms', [DormController::class, 'showDorms'])->name('showdorms');
        Route::get('/adddorm', [DormController::class, 'adddorm'])->name('adddorm');
        Route::get('/dorms/{id}/edit', [Controller::class, 'edit'])->name('dorms.adddorm');
        Route::put('/dorms/{id}', [DormController::class, 'update'])->name('dorms.update');
        Route::get('/profile', [Controller::class, 'showProfile'])->name('profile.edit');
        Route::put('/profile/update', [Controller::class, 'updateProfile'])->name('profile.update');
        Route::post('/dorms/{id}/archive', [DormController::class, 'archive'])->name('dorms.archive');
        Route::get('/room/{id}/edit/{action}', [RoomController::class, 'viewRoom'])->name('room.edit');
        Route::put('/room/{room}', [RoomController::class, 'update'])->name('room.update');
        Route::get('/rooms/{room}/inquire', [RoomController::class, 'inquireRoom'])->name('room.inquire');
        Route::post('/verify', [Controller::class, 'requestVerify'])->name('verify');
        // routes/web.php

        Route::get('/dorms/{dorm}/chat/{chatroom}', [ChatController::class, 'index'])->name('dorm.chat');
        Route::get('/rooms/{room}/chat/{roomchat}', [RoomController::class, 'index'])->name('room.chat');
        Route::post('/dorms/{dormId}/send-message/{roomId}', [ChatController::class, 'sendMessage'])->name('DormSendMessage');
        Route::post('/rooms/{dormId}/send-message/{roomId}', [RoomController::class, 'sendMessage'])->name('RoomSendMessage');
        Route::get('/dorms/{dormId}/chat/{roomId}/fetch-messages', [ChatController::class, 'fetchMessages'])->name('FetchDormMessage');
        Route::get('/rooms/{dormId}/chat/{roomId}/fetch-messages', [RoomController::class, 'fetchMessages'])->name('FetchRoomMessage');
        Route::get('/dorms/{id}/inquire', [ChatController::class, 'inquire'])->name('dorm.inquire');
        Route::get('/chatrooms', [ChatController::class, 'fetchChatrooms'])->name('fetchChatrooms');
        Route::get('/room-chats', [RoomController::class, 'fetchRoomChats'])->name('chatroom.Chatroom');
        Route::post('/rooms/{id}/send-url/{chat_id}', [RoomController::class, 'sendRentFormUrl'])->name('send-url');
        Route::post('/check-form', [RoomController::class, 'checkForm'])->name('check-form');
        Route::get('/notifications', [NotifyController::class, 'getNotifications'])->name('notifies');
        Route::post('/notifications/{id}/mark-as-read', [NotifyController::class, 'markAsRead'])->name('markAsRead');
        Route::post('/mark-messages-read', [MessageController::class, 'markMessagesRead'])->name('message.read');
        Route::post('/mark-as-read', [MessageController::class, 'markasRead']);
        Route::patch('/rentForm/{id}/updateStatus', [RoomController::class, 'updateStatus'])->name('rentForm.updateStatus');
        Route::post('/dorm/{id}/delete-rooms', [RoomController::class, 'deleteRooms'])->name('dorm.deleteRooms');
        Route::post('//dorm/{id}/add-rooms', [RoomController::class, 'addRooms'])->name('dorm.addRooms');
        Route::post('/dorm/{dorm}/favorite', [DormController::class, 'toggleFavorite'])->name('dorm.favorite');
        Route::post('/dorm/{dorm}/views', [DormController::class, 'trackView'])->name('dorm.view');

        Route::put('/rentForms/update/{id}', [RoomController::class, 'updateBook'])->name('rentForm.update');
        Route::post('/bookForm', [RoomController::class, 'storeBook'])->name('rentForm.store');
        Route::post('/rentForm/edit', [RoomController::class, 'createBook'])->name('rentForm.edit');
        Route::get('/user/rent-forms', [Controller::class, 'userRentForms'])->name('user.rentForms');
        Route::post('/rentForm/cancel/{id}', [RoomController::class, 'cancel'])->name('rentForm.cancel');
        Route::patch('/rentForm/leave/{id}', [RoomController::class, 'leaveRent'])->name('rentForm.leave');
        Route::get('/rentForm/extend/{id}', [RoomController::class, 'extendForm'])->name('rentForm.extend');
        Route::post('/extendSubmit', [Controller::class, 'extendRent'])->name('extend.submit');
        Route::get('/extendEdit/{id}', [Controller::class, 'extendEdit'])->name('extendEdit');
        Route::patch('/extendupdate/{id}', [Controller::class, 'extendUpdate'])->name('extendUpdate');
        Route::get('/managetenant', [Controller::class, 'showOwnerDashboard'])->name('managetenant');
        Route::patch('/book/{id}/cancelStatus', [Controller::class, 'updateRequest'])->name('cancellation.updateStatus');
        Route::get('/filter-billing', [Controller::class, 'filterBilling']);
        Route::post('/make-payment/{id}', [Controller::class, 'makePayment'])->name('makePayment');
        Route::get('/reviews/{id}', [Controller::class, 'review'])->name('reviews.store');
        Route::get('/my-reviews', [Controller::class, 'userReviews'])->name('myReviews');
        Route::patch('/reviews/{id}/submit', [Controller::class, 'submitReview'])->name('reviews.submit');
        Route::post('/notifyTenant/{id}', [RoomController::class, 'notifyTenant'])->name('notifyTenant');
        Route::get('/myfavourites', [DormController::class, 'favourites'])->name('favourites');
        Route::get('/ownerhome', [DormController::class, 'ownerDashboard'])->name('owner.Dashboard');
        Route::get('/owner-properties', [DormController::class, 'ownerProperty'])->name('owner.Property');
        Route::get('/owner-properties/archived', [DormController::class, 'archivedProperty'])->name('owner.archived');
        Route::get('/owner-history', [HomeController::class, 'history'])->name('owner.history');
        Route::post('/report', [DormController::class, 'storeReport'])->name('report.store');
        Route::post('/notify-tenant/{tenantId}', [NotifyController::class, 'sendUpcomingStayNotification']);
        Route::patch('/process-payment/{rent_form_id}', [HomeController::class, 'processPayment'])->name('processPayment');
        Route::post('/dorms/restore/{id}', [DormController::class, 'restore'])->name('dorms.restore');

        Route::post('/pusher/auth', function () {
            return Broadcast::auth(request());
        })->middleware('auth');

    });
});
Route::post('/logout', [Controller::class, 'logout'])->name('logout');
// Routes for guests
Route::middleware('guest')->group(function () {
    Route::view('/login', 'login')->name('login.view');
    Route::view('/register', 'register')->name('register.view');
    Route::post('/password/update', [Controller::class, 'updatePassword'])->name('password.update');

    Route::get('/Forgot-password', function () {
        return view('forgot-pass');
    })->name('forgot');
    Route::get('/Privacy-policy', function () {
        return view('privacy-pol');
    })->name('privacy');
    Route::get('/Terms-service', function () {
        return view('terms-serv');
    })->name('Terms');
    Route::post('/forgot-pass/submit', [Controller::class, 'forgotPass'])->name('forgot.pass');
    Route::get('/reset-password/{id}', [Controller::class, 'resetPass'])->name('reset.pass');
});
