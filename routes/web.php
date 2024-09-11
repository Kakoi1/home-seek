<?php

use Chatify\ChatifyMessenger;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\NotifyController;
use App\Http\Controllers\MessageController;

Route::get('/', function () {
    return view('index');
})->name('index');

Auth::routes();
Route::post('/login', [Controller::class, 'login'])->name('login');
Route::post('/register', [Controller::class, 'register'])->name('register');
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
    // routes/web.php

    Route::get('/dorms/{id}/chat/{room_id}', [ChatController::class, 'index'])->name('dorm.chat');
    Route::get('/rooms/{id}/chat/{rooms_id}', [RoomController::class, 'index'])->name('room.chat');
    Route::post('/dorms/{id}/send-message/{room_id}', [ChatController::class, 'sendMessage'])->name('dorm.send-message');
    Route::post('/rooms/{id}/send-message/{chat_id}', [RoomController::class, 'sendMessage'])->name('room.send-message');
    Route::get('/dorms/{dormId}/chat/{roomId}/fetch-messages', [ChatController::class, 'fetchMessages']);
    Route::get('/rooms/{roomsId}/chat/{roomId}/fetch-messages', [RoomController::class, 'fetchMessages']);
    Route::get('/dorms/{id}/inquire', [ChatController::class, 'inquire'])->name('dorm.inquire');
    Route::get('/chatrooms', [ChatController::class, 'fetchChatrooms'])->name('chatrooms.fetchChatrooms');
    Route::get('/room-chats', [RoomController::class, 'fetchRoomChats'])->name('chatroom.fetchChatroom');
    Route::post('/rooms/{id}/send-url/{chat_id}', [RoomController::class, 'sendRentFormUrl'])->name('send-url');
    Route::post('/check-form', [RoomController::class, 'checkForm'])->name('check-form');
    Route::get('/notifications', [NotifyController::class, 'getNotifications']);
    Route::post('/notifications/{id}/mark-as-read', [NotifyController::class, 'markAsRead']);
    Route::post('/mark-messages-read', [MessageController::class, 'markMessagesRead']);
    Route::post('/mark-as-read', [MessageController::class, 'markasRead']);
    Route::patch('/rentForm/{id}/updateStatus', [RoomController::class, 'updateStatus'])->name('rentForm.updateStatus');



    Route::get('/rent-form/{room}', [RoomController::class, 'createRentForm'])
        ->name('rent.form')
        ->middleware('signed');

    Route::post('/rent-form/store', [RoomController::class, 'store'])->name('rent-form.store');

    Route::post('/pusher/auth', function () {
        return Broadcast::auth(request());
    })->middleware('auth');

});

// Routes for guests
Route::middleware('guest')->group(function () {
    Route::view('/login', 'login')->name('login.view');
    Route::view('/register', 'register')->name('register.view');
});
