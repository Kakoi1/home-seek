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


Breadcrumbs::for('owner.Property', function (BreadcrumbTrail $trail) {
    $trail->parent('owner.Dashboard');
    $trail->push('Properties', route('owner.Property'));
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
Breadcrumbs::for('user.rentForms', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Bookings', route('user.rentForms'));
});

// Home > Properties > [Property Name]
