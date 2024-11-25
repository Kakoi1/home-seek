<?php

// routes/breadcrumbs.php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('owner.Dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('owner.Dashboard'));
});
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

// For admin
Breadcrumbs::for('admin.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('admin.dashboard'));
});
Breadcrumbs::for('admin.manageProp', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Manage Listed Property', route('admin.manageProp'));
});
Breadcrumbs::for('reports.view', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Manage User Complaints', route('reports.view'));
});

Breadcrumbs::for('admin.manageuser', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Manage Users', route('admin.manageuser'));
});

Breadcrumbs::for('owner.Property', function (BreadcrumbTrail $trail) {
    $trail->parent('owner.Dashboard');
    $trail->push('Properties', route('owner.Property'));
});
Breadcrumbs::for('owner.archived', function (BreadcrumbTrail $trail) {
    $trail->parent('owner.Property');
    $trail->push('Archives', route('owner.archived'));
});

Breadcrumbs::for('owner.history', function (BreadcrumbTrail $trail) {
    $trail->parent('managetenant');
    $trail->push('History', route('owner.history'));
});
Breadcrumbs::for('managetenant', function (BreadcrumbTrail $trail) {
    $trail->parent('owner.Dashboard');
    $trail->push('Manage Tenants', route('managetenant'));
});

Breadcrumbs::for('showdorms', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Map Search', route('showdorms'));
});
Breadcrumbs::for('myReviews', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('My Reviews', route('myReviews'));
});
Breadcrumbs::for('favourites', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('My Favourites', route('favourites'));
});
Breadcrumbs::for('wallet.cashIn', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Cash In', route('wallet.cashIn'));
});
Breadcrumbs::for('wallet.cashOutForm', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Cash out', route('wallet.cashOutForm'));
});
Breadcrumbs::for('user.rentForms', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Bookings', route('user.rentForms'));
});
Breadcrumbs::for('rentForm.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('user.rentForms');
    $trail->push('Edit Booking', route('rentForm.edit'));
});

// Home > Properties > [Property Name]

