@extends('layouts.homepage')
@section('content')
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="display-1">{{ ucfirst(request()->segment(1)) }}</h1>
                <div class="cta-container">
                    <div class="start-now">
                        <a href="{{route('register')}}">Start now - It’s free</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-200 m-auto">
        <div class="shape illustration_doodle"
             style="background-image: url('{{ asset('images/homepage/03.svg')}}');"></div>

        <div class="container">
            <div class="feature-content">
                <div class="content">
                    <h2>Key Features:</h2>

                </div>


        </div>
    </section>

    <section class="bg-200">
        <div class="container">
            <div class="feature-text-content">
                <h3>Efficient Inventory Management:</h3>
                <ul>
                    <li>Track your stock levels in real-time.</li>
                    <li>Receive low-stock alerts to avoid running out of popular items.</li>
                </ul>
                <h3>Sales Tracking and Reporting:</h3>
                <ul>
                    <li>Monitor your sales performance with detailed reports.</li>
                    <li>Gain insights into your best-selling products and peak sales times.</li>
                    <li> POS system for seamless sales transactions and better customer service.</li>

                </ul>
              
                <h3>Customization:</h3>
                <ul>
                    
                    <li>Personalize your store name for a professional touch.</li>
                    <li>Enable and disable features based on your business needs.</li>
                    <li>Select a color palette that aligns with your brand identity.</li>
                </ul>
                
                
               
                <h2>Why Choose This?</h2>
                <ul>
                    <li><strong>Tailored for Small Vendors:</strong> Our system is specifically designed to meet the unique needs of small vendors at public markets.</li>
                    <li><strong>Local Expertise:</strong> We understand the local market dynamics and provide solutions that work best for your business.</li>
                    <li><strong>Support and Training:</strong> We offer comprehensive support and training to help you make the most of our system.</li>
                </ul>
                <h2>Get Started Today!</h2>
                <p>Join the growing number of small vendors who are transforming their businesses with our management system. Say goodbye to manual tracking and hello to a more efficient, profitable, and stress-free way of running your market stall.</p>
            </div>
        
        </div>
    </section>
    <section>

    <section>
        <div class="container">
            <div class="near-footer">
                <h1>Unleash your growth potential</h1>
                <div class="near-button-container">
                    <div class="near-footer-button">
                        <a href="{{route('login')}}">Start now - It’s free</a>
                    </div>
                </div>
            </div>


        </div>
    </section>
    <style>




.feature-content h2 {
    font-size: 2.5em;
    color: #333;
}
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

.feature-content, .feature-text-content {
    margin-bottom: 30px;
}

.feature-text-content h2 {
    font-size: 2.5em;
    margin-bottom: 20px;
    color: #343a40;
}

.feature-text-content h3 {
    font-size: 2em;
    margin-bottom: 10px;
    color: #000000;
}

.feature-text-content ul {
    list-style: none;
    padding-left: 0;
}

.feature-text-content ul li {
    font-size: 1.2em;
    margin-bottom: 5px;
    color: #6c757d;
    padding-left: 1.5em;
    position: relative;
}

.feature-text-content ul li::before {
    content: '✔';
    color: #000000;
    font-size: 1.5em;
    position: absolute;
    left: 0;
    top: 0;
}

.feature-text-content p {
    font-size: 1.2em;
    margin-top: 20px;
    color: #495057;
}

.feature-text-content .btn {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    font-size: 1.2em;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.feature-text-content .btn:hover {
    background-color: #0056b3;
}

.near-footer {
    text-align: center;
    margin: 50px 0;
}

.near-footer h1 {
    font-size: 3em;
    color: #343a40;
    margin-bottom: 20px;
}

.near-footer .btn {
    font-size: 1.5em;
    padding: 10px 30px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.near-footer .btn:hover {
    background-color: #0056b3;
}

    </style>
@endsection
