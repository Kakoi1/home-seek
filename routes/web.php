<?php

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
    Route::get('/managepage', [AdminController::class, 'manageUsers'])->name('admin.manageuser');
    Route::post('/admin/dorms/approve', [AdminController::class, 'approveDorm'])->name('admin.approveDorm');
    Route::delete('/admin/dorms/{id}', [AdminController::class, 'deleteDorm'])->name('admin.deleteDorm');
    Route::post('/approve-verification/{id}', [AdminController::class, 'approve'])->name('verification.approve');
    Route::post('/reject-verification/{id}', [AdminController::class, 'reject'])->name('verification.reject');
    Route::post('/activate-user/{id}', [AdminController::class, 'activate'])->name('user.activate');
    Route::post('/deactivate-user/{id}', [AdminController::class, 'deactivate'])->name('user.deactivate');


    // Add more admin-specific routes here
});
Route::get('/yawa', function () {
    return view('dorm');
})->name('dds');

Route::get('/', function () {
    return view('index');
})->name('index');

Auth::routes();
Route::post('/login', [Controller::class, 'login'])->name('login');
Route::post('/register', [Controller::class, 'register'])->name('register');
Route::get('/facebook', function () {
    return Socialite::driver('facebook')->redirect();
})->name('facebook.login');
Route::get('/facebook/callback', [Controller::class, 'callbackFromFacebook'])->name('callback');

Route::get('/rent-form/{room}', [RoomController::class, 'createRentForm'])
    ->name('rent.form')
    ->middleware('signed');
Route::post('/collect-email-phone', [Controller::class, 'collectEmailPhone'])->name('collect.email.phone');
Route::post('/verify-email', [Controller::class, 'verifyEmail'])->name('verify.email');

Route::get('/send-email/{user}', [Controller::class, 'redirectEmail'])->name('send.email');
Route::get('/resend/{user}', [Controller::class, 'reSend'])->name('resend.code');

// Middleware group for authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/home', [DormController::class, 'index'])->name('home');
    Route::get('/dorms', [DormController::class, 'index'])->name('dorm');
    Route::get('/dorms/{id}', [DormController::class, 'show'])->name('dorms.posted');

    Route::post('/logout', [Controller::class, 'logout'])->name('logout');

    Route::post('/get-coor', [Controller::class, 'getCoor'])->name('get-coor');
    Route::post('/savedorm', [DormController::class, 'saveDorm'])->name('savedorm');
    Route::get('/showdorms', [DormController::class, 'showDorms'])->name('showdorms');
    Route::get('/adddorm', [DormController::class, 'adddorm'])->name('adddorm');
    Route::get('/dorms/{id}/edit', [Controller::class, 'edit'])->name('dorms.adddorm');
    Route::put('/dorms/{id}', [DormController::class, 'update'])->name('dorms.update');
    Route::get('/profile', [Controller::class, 'showProfile'])->name('profile');
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

    Route::get('/rentForm/{roomid}/create/{id?}', [RoomController::class, 'createBook'])->name('rentForm.create');
    Route::post('/rentForms/update/{id}', [RoomController::class, 'updateBook'])->name('rentForm.update');
    Route::post('/rentForms', [RoomController::class, 'storeBook'])->name('rentForm.store');
    Route::get('/rentForm/{rent}/edit', [RoomController::class, 'editBook'])->name('rentForm.edit');
    Route::patch('/rentForm/{rent}', [RoomController::class, 'updateBook'])->name('rentForm.update');
    Route::get('/user/rent-forms', [Controller::class, 'userRentForms'])->name('user.rentForms');
    Route::post('/rentForm/cancel/{id}', [RoomController::class, 'cancel'])->name('rentForm.cancel');
    Route::post('/rentForm/leave/{id}', [RoomController::class, 'leaveRent'])->name('rentForm.leave');
    Route::get('/rentForm/extend/{id}', [RoomController::class, 'extendForm'])->name('rentForm.extend');
    Route::post('/extendSubmit', [Controller::class, 'extendRent'])->name('extend.submit');
    Route::get('/extendEdit/{id}', [Controller::class, 'extendEdit'])->name('extendEdit');
    Route::patch('/extendupdate/{id}', [Controller::class, 'extendUpdate'])->name('extendUpdate');
    Route::get('/managetenant', [Controller::class, 'showOwnerDashboard'])->name('managetenant');
    Route::patch('/rentForm/{id}/extendStatus', [Controller::class, 'updateRequest'])->name('rentForm.extendStatus');
    Route::get('/billings', [Controller::class, 'filterBilling'])->name('billing.filter');
    Route::post('/make-payment/{id}', [Controller::class, 'makePayment'])->name('makePayment');
    Route::get('/reviews/{id}', [Controller::class, 'review'])->name('reviews.store');
    Route::get('/my-reviews', [Controller::class, 'userReviews'])->name('myReviews');
    Route::patch('/reviews/{id}/submit', [Controller::class, 'submitReview'])->name('reviews.submit');






    Route::post('/pusher/auth', function () {
        return Broadcast::auth(request());
    })->middleware('auth');

});

// Routes for guests
Route::middleware('guest')->group(function () {
    Route::view('/login', 'login')->name('login.view');
    Route::view('/register', 'register')->name('register.view');
});
