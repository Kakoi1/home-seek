@extends('layouts.app')

@section('title', 'HomeSeek')

@section('content')
<style>
    .carousel {
        position: relative;
        width: 100%;
        max-width: 400px;
        margin: auto;
        overflow: hidden;
    }

    .carousel-item {
        display: none;
        opacity: 0;
        transition: opacity 1s ease-in-out;
        /* Smooth transition for fading in/out */
    }

    .carousel-item.active {
        display: block;
        opacity: 1;
        /* Fully visible when active */
    }

    .card img {
        object-fit: cover !important;
        border-radius: 15px !important;
        /* height:  !important; */
        height: 300px !important;
    }

    #loadingOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #progressCircle {
        transition: stroke-dashoffset 0.4s ease;
    }

    #loadingText {
        position: absolute;
        top: 40%;
        left: 40%;
        font-size: 18px;
        color: #fff;
        font-weight: bold;
    }

    .carousel-item {
        transition: transform 0.7s ease-in-out, opacity 5s ease-in-out;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        filter: invert(1);
        /* Optional: Makes the controls white for better visibility */
    }
</style>
<section class="homepage" id="home">
    <div class="content">
        <div class="text">
            <h1>Comprehensive List of Local Stay Escapes</h1>
            <p>
                Discover Your Ideal Dorm or Apartment in Minglanilla.</p>
        </div>
        <a href="{{route('home')}}">Browse Listing</a>
    </div>

</section>

<section class="services d-flex justify-content-center" id="services" style="margin-top: 5vh;">
    <h2>Our Services</h2>
    <p>Browse through a comprehensive listing of dormitories and apartments in Minglanilla, offering various
        amenities and
        rental options.</p>
    <ul class="cards">
        <li class="card">
            <img src="images/white-bedroom.jpg" alt="img">
            <h3>Diverse Listings</h3>
            <p>Browse through a comprehensive listing of dormitories and apartments in Minglanilla, offering various
                amenities and
                rental options.</p>
        </li>
        <li class="card">
            <img src="images/mini=house.jpg" alt="img">
            <h3>Detailed Information</h3>
            <p>Each listing includes detailed descriptions, photos, and rental specifics of available dorms and
                apartments. Filter by price, location, amenities, and more.</p>
        </li>
        <li class="card">
            <img src="images/search-magnifier.avif" alt="img">
            <h3>Customized Searches</h3>
            <p>Tell us your preferences, and we'll tailor our recommendations to match your requirements for
                location, budget, and
                amenities.</p>
        </li>
        <!-- <li class="card">
                <img src="team.jpg" alt="img">
                <h3>Backpacks</h3>
                <p>Carry your essentials comfortably with our durable and functional camping backpacks.</p>
            </li>
            <li class="card">
                <img src="team.jpg" alt="img">
                <h3>Camp Chairs</h3>
                <p>Relax and unwind in style with our comfortable and portable camping chairs.</p>
            </li>
            <li class="card">
                <img src="team.jpg" alt="img">
                <h3>Camp Lights</h3>
                <p>Illuminate your campsite with our reliable and energy-efficient camping lights.</p>
            </li> -->
    </ul>
</section>

<section class="portfolio d-flex justify-content-center" id="portfolio">
    <!-- <span> -->
    <h2>Why Choose Us?</h2>
    <p>Experience the advantages of our trusted rental platform.</p>
    <!-- </span> -->
    <ul class="cards">
        <li class="card">
            <img src="images/house-isolated-field_1303-23773.jpg" alt="img">
            <h3>Local Expertise</h3>
            <p>Our deep understanding of Minglanilla ensures you access to the best rental options available in the
                area.</p>
        </li>
        <li class="card">
            <img src="images/high-angle.jpg" alt="img">
            <h3>Comprehensive Listings</h3>
            <p>From apartments to shared homes, find a variety of rental options that suit your needs. Explore listings
                across multiple cities and neighborhoods.
            </p>
        </li>
        <li class="card">
            <img src="images/notifs.jpg" alt="img">
            <h3>Real-Time <br>Notifications</h3>
            <p>Stay updated with instant notifications for booking requests, confirmations, and tenant inquiries. Our
                timely alerts help you manage your rentals or reservations effortlessly.</p>
        </li>
        <!-- <li class="card">
                <img src="team.jpg" alt="img">
                <h3>Lorem ipsum dolor sit amet.</h3>
                <p>Discover the wonders of lush forests and immerse yourself in nature's beauty.</p>
            </li>
            <li class="card">
                <img src="team.jpg" alt="img">
                <h3>Lorem ipsum dolor sit amet.</h3>
                <p>Experience the freedom of road trips and camping adventures with our RV rentals.</p>
            </li>
            <li class="card">
                <img src="team.jpg" alt="img">
                <h3>Lorem ipsum dolor sit amet.</h3>
                <p>Embark on a unique desert camping experience and witness stunning landscapes.</p>
            </li> -->
    </ul>
</section>
<section class="listings d-flex justify-content-center" id="listings">
    <h2>Top Rated Listings</h2>
    <div class="row listing">
        <ul class="cards">
            @foreach ($topRatedDorms as $dorm)
                        @php
                            $images = json_decode($dorm->image, true);
                            $fullAddress = $dorm->address;

                            // Split the string by commas
                            $addressParts = explode(',', $fullAddress);
                            $shortAddress = implode(', ', array_slice($addressParts, 0, 3));
                        @endphp
                        <li class="card">
                            <div id="carousel-{{ $dorm->id }}" class="carousel slide" data-ride="carousel" data-interval="3000">
                                <div class="carousel-inner">
                                    @if (is_array($images) && !empty($images))
                                        @foreach($images as $key => $image)
                                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                <img class="d-block w-100"
                                                    src="{{ asset('https://storage.googleapis.com/homeseek-profile-image/' . $image) }}"
                                                    alt="{{ $dorm->name }}">
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="carousel-item active">
                                            <p>No images available.</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Optional: Add controls (prev/next) -->
                                <a class="carousel-control-prev" href="#carousel-{{ $dorm->id }}" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carousel-{{ $dorm->id }}" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>

                            <div class="overlay" style="cursor: pointer;"
                                onclick="location.href = '{{route('dorms.posted', Crypt::encrypt($dorm->id))}}'">
                                <div class="text">
                                    <h4>{{ $dorm->name }}</h4>
                                    <p>{{ $shortAddress }}</p>
                                    <p>Rating: {{ number_format($dorm->reviews_avg_rating, 1) }} / 5</p>
                                </div>
                            </div>
                        </li>
            @endforeach
        </ul>
    </div>
</section>

>


<section class="about d-flex justify-content-center" id="about">
    <h2>About Us</h2>
    <p>Choose Home-Seek to discover your ideal rental room or apartment in Minglanilla today.</p>
    <div class="row company-info">
        <h3>Our Story</h3>
        <p>At Home-Seek, we aim to make renting easy for everyone. Our goal is to connect tenants with
            property owners through a simple and secure online platform. Whether you're looking for a cozy apartment or
            a room to share, we’re here to help you find the right place.

            We started Home-Seek in 2024 because we wanted to improve the rental experience for everyone.
            Our friendly team understands the challenges that come with renting and is dedicated to providing you with
            the best support possible. We believe in being open and honest, ensuring that you can trust our listings and
            feel safe when booking.

            Join us as we make finding your next home a smooth and enjoyable journey!

        </p>
    </div>
    <div class="row mission-vision">
        <!-- <h3>Our Mission</h3>
            <p>At Camping Gear Experts, our mission is to equip outdoor enthusiasts with top-notch camping gear and
                essentials that enhance their outdoor experiences. We strive to provide reliable, durable, and
                innovative products that contribute to memorable adventures and lasting memories.</p> -->
        <h3>Our Goals</h3>
        <p>At Home-Seek, our primary goal is to connect renters with their ideal living spaces in Minglanilla. We
            aim to exceed
            expectations by providing comprehensive listings, expert guidance, and exceptional customer service. Our
            goal is not
            just to find you a place to live but to ensure it feels like home.</p>
    </div>




</section>

<section class="contact d-flex justify-content-center" id="contact">
    <h2>Contact Us</h2>
    <p>Reach out to us for any inquiries or feedback.</p>
    <div class="row">
        <div class="col information">
            <div class="contact-details">
                <p><i class="fas fa-map-marker-alt"></i> Poblacion Ward II, Minglanilla Cebu</p>
                <p><i class="fas fa-envelope"></i> homeseek@company.com</p>
                <p><i class="fas fa-phone"></i> 09771653962</p>
                <p><i class="fas fa-clock"></i> Monday - Friday: 9:00 AM - 5:00 PM</p>
                <p><i class="fas fa-clock"></i> Saturday: 10:00 AM - 3:00 PM</p>
                <p><i class="fas fa-clock"></i> Sunday: Closed</p>
                <!-- <p><i class="fas fa-globe"></i> www.codingnepalweb.com</p> -->
            </div>
        </div>
        <div class="col form">
            <p id="responseMessage" style="display:none; color:green;"></p>
            <form id="contactForm">
                @csrf
                <input type="text" placeholder="Name*" name="name" required>
                <input type="email" placeholder="Email*" name="email" required>
                <textarea placeholder="Message*" name="message" required></textarea>
                <button id="submit" type="submit">
                    <i class="fas fa-envelope"></i>
                    <span>Send Message</span>
                </button>
            </form>
        </div>
    </div>

</section>
<div id="loadingOverlay"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9999; display: flex; justify-content: center; align-items: center;">
    <div style="width: 100px; height: 100px; position: relative;">
        <!-- Circular Progress Background -->
        <svg width="150" height="150" viewBox="0 0 100 100">
            <circle cx="50" cy="50" r="45" stroke="#e0e0e0" stroke-width="8" fill="none" />
            <circle id="progressCircle" cx="50" cy="50" r="45" stroke="#4caf50" stroke-width="8" fill="none"
                stroke-dasharray="283" stroke-dashoffset="283" transform="rotate(-90 50 50)" />
        </svg>
        <div id="loadingText"
            style="position: absolute; top: 60%; left: 60%; font-size: 15px; color: #fff; font-weight: bold;">1%</div>
    </div>
</div>

@endsection
<script>
    try {
        $('.carousel').on('slide.bs.carousel', function () {
            $('.carousel-item').css('opacity', 0); // Set opacity to 0 when sliding
        });

        $('.carousel').on('slid.bs.carousel', function () {
            $('.carousel-item.active').css('opacity', 1); // Fade in the active item
        });
    } catch (error) {

    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('contactForm');
        const loadingOverlay = document.getElementById('loadingOverlay');
        const progressCircle = document.getElementById('progressCircle');
        const loadingText = document.getElementById('loadingText');

        // Hide the loading overlay on page load, just in case it was shown earlier
        loadingOverlay.style.display = 'none';

        form.addEventListener('submit', async (e) => {
            e.preventDefault(); // Prevent the default form submission

            // Only show the loading overlay when form is being submitted
            loadingOverlay.style.display = 'flex';

            const formData = new FormData(form);
            const csrfToken = document.querySelector('input[name="_token"]').value;

            // Initialize progress at 1%
            let progress = 1;
            const dasharray = 283; // Circumference of the circle (2 * PI * radius)
            progressCircle.style.strokeDasharray = dasharray;
            progressCircle.style.strokeDashoffset = dasharray;

            // Simulate progress incrementally while the AJAX request is ongoing
            const progressInterval = setInterval(() => {
                if (progress < 100) {
                    progress += Math.random() * 5; // Increment by random value to simulate loading
                    progress = Math.min(progress, 100); // Ensure it doesn't exceed 100%

                    const offset = dasharray - (progress / 100) * dasharray;
                    progressCircle.style.strokeDashoffset = offset;
                    loadingText.textContent = `${Math.round(progress)}%`;
                }
            }, 100);

            try {
                // Submit the form data using AJAX (fetch)
                const response = await fetch("{{ route('contact.submit') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: formData,
                });

                // Parse response JSON
                const data = await response.json();

                // If submission is successful
                if (response.ok && data.success) {
                    // Stop the progress animation
                    clearInterval(progressInterval);
                    progressCircle.style.strokeDashoffset = 0;
                    loadingText.textContent = 'Message Sent!';

                    // Show success message using SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Message Sent!',
                        text: data.message,
                        timer: 3000,
                    });

                    // Reset form
                    form.reset();
                } else {
                    // Stop the progress animation
                    clearInterval(progressInterval);
                    progressCircle.style.strokeDashoffset = 0;
                    loadingText.textContent = 'Failed to send.';

                    // Show error message using SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: data.message || 'Something went wrong.',
                    });
                }
            } catch (error) {
                // Stop the progress animation
                clearInterval(progressInterval);
                progressCircle.style.strokeDashoffset = 0;
                loadingText.textContent = '100% - Error occurred.';

                // Show error if AJAX fails
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred. Please try again.',
                });
                console.error('Error:', error);
            } finally {
                // Hide the loading overlay after submission (even on success or failure)
                setTimeout(() => {
                    loadingOverlay.style.display = 'none';
                }, 1000); // Delay hiding to show the final state of the progress circle
            }
        });
    });


</script>