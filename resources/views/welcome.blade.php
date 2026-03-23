<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASPN Overseas - Manpower Fulfillment Solutions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100">
    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>
        </div>
        
        <!-- Navigation -->
        <nav class="relative z-10 bg-white/80 backdrop-blur-md shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 gradient-bg rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-briefcase text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-800">ASPN Overseas</h1>
                            <p class="text-xs text-gray-500">Manpower Fulfillment Solutions</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.login') }}" class="px-4 py-2 text-gray-600 hover:text-gray-900 transition">
                            Admin Login
                        </a>
                    </div>
                </div>
            </div>
        </nav>
        
        <!-- Hero Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-sm font-medium mb-6">
                        <i class="fas fa-globe-asia mr-2"></i>
                        Global Manpower Solutions
                    </div>
                    <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
                        Connecting Talent
                        <span class="gradient-text">Across Borders</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8">
                        ASPN Overseas provides comprehensive manpower fulfillment services, connecting skilled professionals with international opportunities.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('admin.login') }}" class="px-6 py-3 gradient-bg text-white rounded-xl hover:shadow-lg transition shadow-md flex items-center">
                            <i class="fas fa-chalkboard-user mr-2"></i>
                            Admin Portal
                        </a>
                        <a href="#" class="px-6 py-3 bg-white text-gray-700 rounded-xl border border-gray-300 hover:shadow-lg transition flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            Learn More
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 mt-12 pt-8 border-t border-gray-200">
                        <div>
                            <p class="text-2xl font-bold text-gray-900">500+</p>
                            <p class="text-sm text-gray-500">Happy Clients</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">50K+</p>
                            <p class="text-sm text-gray-500">Professionals</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">25+</p>
                            <p class="text-sm text-gray-500">Countries</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl blur-3xl opacity-20 animate-float"></div>
                    <div class="relative bg-white rounded-3xl shadow-2xl overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?w=600&h=400&fit=crop" alt="Team" class="w-full h-80 object-cover">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-6">
                            <p class="text-white font-semibold">Trusted by leading organizations worldwide</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Features Section -->
    <div class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose ASPN Overseas?</h2>
                <p class="text-xl text-gray-600">Comprehensive manpower solutions tailored to your needs</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center card-hover">
                    <div class="w-16 h-16 gradient-bg rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-user-tie text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Expert Recruitment</h3>
                    <p class="text-gray-500 text-sm">Access to vetted professionals across multiple industries</p>
                </div>
                
                <div class="text-center card-hover">
                    <div class="w-16 h-16 gradient-bg rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-globe text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Global Reach</h3>
                    <p class="text-gray-500 text-sm">Operations in 25+ countries with local expertise</p>
                </div>
                
                <div class="text-center card-hover">
                    <div class="w-16 h-16 gradient-bg rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-clock text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Fast Placement</h3>
                    <p class="text-gray-500 text-sm">Average placement time of just 7 days</p>
                </div>
                
                <div class="text-center card-hover">
                    <div class="w-16 h-16 gradient-bg rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-headset text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">24/7 Support</h3>
                    <p class="text-gray-500 text-sm">Round-the-clock assistance for all your needs</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Services Section -->
    <div class="bg-gray-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Services</h2>
                <p class="text-xl text-gray-600">Comprehensive manpower solutions for every need</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-6 shadow-md card-hover">
                    <div class="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-search text-white text-lg"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Candidate Screening</h3>
                    <p class="text-gray-500 text-sm">Thorough verification and background checks for all candidates</p>
                </div>
                
                <div class="bg-white rounded-2xl p-6 shadow-md card-hover">
                    <div class="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-file-alt text-white text-lg"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Visa Processing</h3>
                    <p class="text-gray-500 text-sm">End-to-end visa and immigration support</p>
                </div>
                
                <div class="bg-white rounded-2xl p-6 shadow-md card-hover">
                    <div class="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-chart-line text-white text-lg"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Training Programs</h3>
                    <p class="text-gray-500 text-sm">Pre-employment training and skill development</p>
                </div>
                
                <div class="bg-white rounded-2xl p-6 shadow-md card-hover">
                    <div class="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-handshake text-white text-lg"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Contract Management</h3>
                    <p class="text-gray-500 text-sm">Professional contract management and compliance</p>
                </div>
                
                <div class="bg-white rounded-2xl p-6 shadow-md card-hover">
                    <div class="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-chalkboard-user text-white text-lg"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Onboarding Support</h3>
                    <p class="text-gray-500 text-sm">Seamless integration into new work environments</p>
                </div>
                
                <div class="bg-white rounded-2xl p-6 shadow-md card-hover">
                    <div class="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-chart-simple text-white text-lg"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Market Insights</h3>
                    <p class="text-gray-500 text-sm">Latest industry trends and salary benchmarks</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- CTA Section -->
    <div class="gradient-bg py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Ready to Transform Your Workforce?</h2>
            <p class="text-xl text-white/90 mb-8">Join hundreds of satisfied clients who trust ASPN Overseas</p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('admin.login') }}" class="px-8 py-3 bg-white text-indigo-600 rounded-xl font-semibold hover:shadow-lg transition">
                    <i class="fas fa-sign-in-alt mr-2"></i>Admin Login
                </a>
                <a href="#" class="px-8 py-3 bg-white/20 text-white rounded-xl font-semibold hover:bg-white/30 transition">
                    <i class="fas fa-phone-alt mr-2"></i>Contact Us
                </a>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 gradient-bg rounded-xl flex items-center justify-center">
                            <i class="fas fa-briefcase text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">ASPN Overseas</h3>
                            <p class="text-xs text-gray-400">Manpower Fulfillment</p>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm">Connecting talent across borders since 2010</p>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition">Services</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Contact Info</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><i class="fas fa-phone mr-2"></i> +1 234 567 890</li>
                        <li><i class="fas fa-envelope mr-2"></i> info@aspnoverseas.com</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Global Headquarters, Dubai</li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-indigo-600 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-indigo-600 transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-indigo-600 transition">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-indigo-600 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} ASPN Overseas. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>