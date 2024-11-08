{{-- resources/views/privacy-policy.blade.php --}}

@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')
<style>
    /* public/css/privacy-policy.css */

    /* Body and Layout */


    .containers {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }

    h1,
    h2,
    h3 {
        color: #2c3e50;
    }

    p {
        margin-bottom: 1.5em;
        font-size: 1rem;
        color: #555;
    }

    ul {
        list-style-type: disc;
        padding-left: 20px;
        margin-bottom: 1.5em;
    }

    strong {
        font-weight: bold;
    }

    /* Card Styles */
    .cards {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-top: 20px;
    }

    /* Header */
    .card-headers {
        text-align: center;
        padding-bottom: 20px;
    }

    .card-headers h2 {
        font-size: 2rem;
        color: #333;
    }

    /* Section Titles */
    h3 {
        font-size: 1.5rem;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    /* Footer */

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            padding: 15px;
        }

        .card {
            padding: 15px;
        }

        h2 {
            font-size: 1.5rem;
        }

        h3 {
            font-size: 1.2rem;
        }

        p {
            font-size: 0.9rem;
        }
    }
</style>
<div class="containers">
    <div class="cards">
        <div class="card-headers">
            <h2>Privacy Policy</h2>
        </div>
        <div class="card-bodys">
            <p>Effective date: {{ \Carbon\Carbon::now()->format('F j, Y') }}</p>

            <p>Welcome to {{ config('app.name') }}! This privacy policy explains how we collect, use, and safeguard your
                personal information when you use our website and services.</p>

            <h3>1. Information We Collect</h3>
            <p>We may collect the following types of information:</p>
            <ul>
                <li><strong>Personal Information:</strong> Name, email address, phone number, etc.</li>
                <li><strong>Usage Data:</strong> Information about how you use our services (e.g., IP address, browser
                    type, pages visited).</li>
                <li><strong>Cookies and Tracking Technologies:</strong> We may use cookies, web beacons, and other
                    tracking technologies to improve user experience.</li>
            </ul>

            <h3>2. How We Use Your Information</h3>
            <p>We use your information to:</p>
            <ul>
                <li>Provide and maintain our services</li>
                <li>Communicate with you, including sending you updates or promotional material (if opted in)</li>
                <li>Analyze usage to improve our services</li>
                <li>Comply with legal obligations</li>
            </ul>

            <h3>3. Sharing Your Information</h3>
            <p>We do not sell, rent, or trade your personal information to third parties. However, we may share your
                information with trusted third-party service providers who help us operate our services, such as:</p>
            <ul>
                <li>Analytics providers</li>
                <li>Payment processors</li>
                <li>Email service providers</li>
            </ul>
            <p>All third parties are obligated to keep your data secure and may only use it for the purpose of providing
                services to us.</p>

            <h3>4. Data Security</h3>
            <p>We take the security of your data seriously and employ reasonable security measures to protect your
                personal information. However, no data transmission method over the internet is 100% secure, and we
                cannot guarantee the absolute security of your information.</p>

            <h3>5. Your Data Protection Rights</h3>
            <p>You have the following rights regarding your personal data:</p>
            <ul>
                <li><strong>Access:</strong> You can request access to the personal information we hold about you.</li>
                <li><strong>Correction:</strong> You can update or correct your personal data.</li>
                <li><strong>Deletion:</strong> You can request the deletion of your personal information, subject to
                    certain limitations.</li>
                <li><strong>Opt-Out:</strong> You may opt-out of marketing communications at any time by following the
                    unsubscribe instructions in the email.</li>
            </ul>

            <h3>6. Changes to This Privacy Policy</h3>
            <p>We may update this Privacy Policy from time to time. When we make changes, we will update the effective
                date at the top of this page and notify you through other means where appropriate.</p>

            <h3>7. Contact Us</h3>
            <p>If you have any questions or concerns about this Privacy Policy or how we handle your personal
                information, please contact us at:</p>
            <p><strong>Email:</strong> lopezrolandshane@gmail.com</p>
            <p><strong>Address:</strong> Ward 2, Minglanilla, Cebu</p>
        </div>
    </div>
</div>
@endsection