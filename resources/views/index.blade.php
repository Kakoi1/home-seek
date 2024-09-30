@extends('layouts.app')

@section('title', 'HomeSeek')

@section('content')

<section class="homepage" id="home">
    <div class="content">
        <div class="text">
            <h1>Comprehensive List of Local Stay Escapes</h1>
            <p>
                Discover Your Ideal Dorm or Apartment in Minglanilla.</p>
        </div>
        <a href="#services">Our Services</a>
    </div>

</section>

<section class="services d-flex justify-content-center" id="services">
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
            <p>Stay updated with instant notifications for booking requests, confirmations, and tenant inquiries. Our timely alerts help you manage your rentals or reservations effortlessly.</p>
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
    <h2>Featured Listings</h2>
    <div class="row listing">


        <ul class="cards">
            <li class="card">
                <img src="images/living room.jpg" alt="John Doe">
                <div class="overlay">
                    <div class="text">
                        <h4>Cozy Studio Apartment</h4>
                        <p>Studio apartment with modern furnishings and city views.</p>
                    </div>
                </div>
            </li>
            <li class="card">
                <img src="images/student dorm.jpg" alt="Jane Smith">
                <div class="overlay">
                    <div class="text">
                        <h4>Student Dorm</h4>
                        <p>
                            Very close to universities and colleges in Minglanilla. Has common
                            facilities.</p>
                    </div>
                </div>
            </li>
            <li class="card">
                <img src="images/house-with-garden.jpg" alt="Mark Johnson">
                <div class="overlay">
                    <div class="text">
                        <h4>Family House with Garden</h4>
                        <p>Suitable for families. It has multiple bedrooms, large garden, and parking space.</p>
                    </div>
                </div>
            </li>
            <li class="card">
                <img src="images/houseclosetomall.jpg" alt="Sarah Brown">
                <div class="overlay">
                    <div class="text">
                        <h4>Convenient Locations</h4>
                        <p>Close to shopping centers and restaurants. And Easy access to public transportation.</p>
                    </div>
                </div>
            </li>
            <li class="card">
                <img src="images/houseemployes.jpg" alt="Sarah Brown">
                <div class="overlay">
                    <div class="text">
                        <h4>Apartment for Employees</h4>
                        <p>Convenient locations close to business districts.
                            High-speed internet and utilities included.</p>
                    </div>
                </div>
            </li>
            <li class="card">
                <img src="images/beach.jpg" alt="Sarah Brown">
                <div class="overlay">
                    <div class="text">
                        <h4>Vacation Rentals</h4>
                        <p>Comfortable apartments ideal for short-term stays. Close to tourist attractions and
                            beaches.
                        </p>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</section>

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
            <form>
                <input type="text" placeholder="Name*" required>
                <input type="email" placeholder="Email*" required>
                <textarea placeholder="Message*" required></textarea>
                <button id="submit" type="submit"><i class="fas fa-envelope"></i><span>Send Message</span></button>
            </form>
        </div>
    </div>

</section>
@endsection