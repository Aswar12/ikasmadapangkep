<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic&display=swap" rel="stylesheet">

<!-- AOS Animation -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<!-- Custom Styles -->
<style>
    :root {
        --primary-color: #8E1920; /* Maroon - warna utama */
        --primary-light: #B83038; /* Maroon yang lebih terang */
        --primary-dark: #5E1014; /* Maroon yang lebih gelap */
        --secondary-color: #1A3A6A; /* Navy Blue */
        --secondary-light: #2C5699; /* Navy Blue yang lebih terang */
        --secondary-dark: #122744; /* Navy Blue yang lebih gelap */
        --accent-color: #D4AF37; /* Gold accent */
        --accent-light: #E9C767; /* Gold yang lebih terang */
        --accent-dark: #A88A29; /* Gold yang lebih gelap */
        --success-color: #28a745;
        --warning-color: #ffc107;
        --danger-color: #dc3545;
        --dark-color: #2c3e50;
        --light-color: #f8f9fa;
        --gradient-primary: linear-gradient(135deg, var(--primary-light), var(--primary-dark));
        --gradient-secondary: linear-gradient(135deg, var(--secondary-light), var(--secondary-dark));
        --gradient-accent: linear-gradient(135deg, var(--accent-light), var(--accent-dark));
    }
    
    body {
        font-family: 'Montserrat', sans-serif;
        color: #333;
    }
    
    h1, h2, h3, h4, h5, h6 {
        font-family: 'Merriweather', serif;
        font-weight: 700;
    }
    
    .section-padding {
        padding: 100px 0;
    }
    
    /* Navigation */
    #mainNav {
        transition: all 0.3s ease;
        background: transparent;
        padding: 10px 0;
    }
    
    #mainNav.navbar-scrolled {
        background: linear-gradient(135deg, var(--primary-dark), var(--secondary-dark));
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        padding: 8px 0;
    }
    
    #mainNav .navbar-nav .nav-item .nav-link {
        color: rgba(255, 255, 255, 0.9);
        font-weight: 600;
        font-size: 0.9rem;
        padding: 0.75rem 0;
        letter-spacing: 0.1rem;
        text-transform: uppercase;
    }
    
    #mainNav.navbar-scrolled .navbar-nav .nav-item .nav-link {
        color: white;
    }
    
    #mainNav .navbar-nav .nav-item .nav-link:hover,
    #mainNav .navbar-nav .nav-item .nav-link:active {
        color: var(--accent-color);
    }
    
    /* Navbar styling for buttons */
    #mainNav .navbar-nav .nav-item .nav-link.btn {
        margin: 0 5px;
        padding: 8px 15px !important;
        border-radius: 30px;
    }
    
    #mainNav .navbar-nav .nav-item .nav-link.btn-outline-primary {
        color: white;
        border: 1px solid var(--accent-color);
    }
    
    #mainNav .navbar-nav .nav-item .nav-link.btn-outline-primary:hover {
        background-color: var(--accent-color);
        color: var(--secondary-dark);
    }
    
    #mainNav .navbar-nav .nav-item .nav-link.btn-primary {
        background: var(--gradient-accent);
        color: var(--secondary-dark);
        border: none;
    }
    
    #mainNav .navbar-nav .nav-item .nav-link.btn-primary:hover {
        background: var(--accent-light);
    }
    
    /* Hero Section */
    .hero-section {
        height: 100vh;
        min-height: 600px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-top: 0;
        position: relative;
    }
    
    .hero-content {
        position: relative;
        z-index: 10;
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
        color: white;
    }
    
    .hero-content h1 {
        font-size: 3.5rem;
        margin-bottom: 2rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }
    
    .hero-content p {
        font-size: 1.25rem;
        margin-bottom: 2.5rem;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }
    
    /* Cards */
    .card-feature {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        border: none;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .card-feature:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .btn-primary {
        background: var(--gradient-primary);
        border-color: var(--primary-color);
        border-radius: 30px;
        padding: 10px 25px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background: var(--primary-color);
        border-color: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    
    .btn-outline-primary {
        color: var(--primary-color);
        border-color: var(--primary-color);
        border-radius: 30px;
        padding: 10px 25px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    
    .btn-outline-primary:hover {
        background: var(--gradient-primary);
        border-color: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    
    .btn-outline-light {
        border-radius: 30px;
        padding: 10px 25px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    
    .btn-outline-light:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    /* Section Headings */
    .section-heading {
        margin-bottom: 3rem;
        text-align: center;
        position: relative;
    }
    
    .section-heading h2 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: var(--dark-color);
        position: relative;
        padding-bottom: 1rem;
    }
    
    .section-heading h2:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: var(--gradient-primary);
    }
    
    .section-heading p {
        font-size: 1.2rem;
        color: var(--secondary-color);
    }
    
    /* About Section */
    .about-image {
        border-radius: 10px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .about-image img {
        transition: transform 0.5s ease;
    }
    
    .about-image:hover img {
        transform: scale(1.05);
    }
    
    .feature-icon {
        width: 60px;
        height: 60px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--gradient-primary);
        color: white;
        font-size: 1.5rem;
        margin-right: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(142, 25, 32, 0.3);
        flex-shrink: 0;
        padding: 0;
    }
    
    .feature-box:hover .feature-icon {
        transform: scale(1.05);
    }
    
    /* Departments Section */
    .department-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--gradient-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        margin: 0 auto 1.5rem;
        transition: all 0.3s ease;
    }
    
    .card-feature:hover .department-icon {
        transform: scale(1.1);
        background: var(--gradient-primary);
    }
    
    /* Events Section */
    .event-date {
        background: var(--gradient-primary);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        font-weight: 600;
    }
    
    .event-card img {
        height: 220px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .event-card:hover img {
        transform: scale(1.05);
    }
    
    /* Testimonials */
    .testimonial-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--gradient-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin-right: 1rem;
    }
    
    .testimonial-quote {
        font-size: 2rem;
        color: var(--primary-color);
        opacity: 0.5;
    }
    
    /* Footer */
    .footer {
        background: linear-gradient(135deg, var(--secondary-dark), var(--primary-dark));
        padding: 70px 0 20px;
    }
    
    .footer h5 {
        color: white;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 10px;
        position: relative;
    }
    
    .footer h5:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 2px;
        background: var(--gradient-accent);
    }
    
    .social-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }
    
    .social-icon:hover {
        background-color: var(--accent-color);
        transform: translateY(-3px);
    }
    
    /* Back to top button */
    .back-to-top {
        position: fixed;
        visibility: hidden;
        opacity: 0;
        right: 15px;
        bottom: 15px;
        z-index: 996;
        background: var(--gradient-primary);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        color: white;
        transition: all 0.4s;
    }
    
    .back-to-top.active {
        visibility: visible;
        opacity: 1;
    }
    
    .back-to-top:hover {
        background: var(--gradient-secondary);
        color: white;
    }
    
    /* Animation classes */
    .fade-up {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    
    .fade-up.show {
        opacity: 1;
        transform: translateY(0);
    }
    
    /* Media Queries */
    @media (max-width: 992px) {
        #mainNav {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-dark));
            padding: 10px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        #mainNav .navbar-nav .nav-item .nav-link {
            color: white;
        }
        
        .hero-content h1 {
            font-size: 2.5rem;
        }
        
        .section-padding {
            padding: 60px 0;
        }
    }
    
    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 2rem;
        }
        
        .hero-content p {
            font-size: 1rem;
        }
        
        .section-heading h2 {
            font-size: 2rem;
        }
    }
</style>
